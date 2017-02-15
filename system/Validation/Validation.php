<?php namespace CodeIgniter\Validation;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\View\RendererInterface;

class Validation implements ValidationInterface
{
	/**
	 * Files to load with validation functions.
	 *
	 * @var array
	 */
	protected $ruleSetFiles;

	/**
	 * The loaded instances of our validation files.
	 *
	 * @var array
	 */
	protected $ruleSetInstances = [];

	/**
	 * Stores the actual rules that should
	 * be ran against $data.
	 *
	 * @var array
	 */
	protected $rules = [];

	/**
	 * The data that should be validated,
	 * where 'key' is the alias, with value.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Any generated errors during validation.
	 * 'key' is the alias, 'value' is the message.
	 *
	 * @var array
	 */
	protected $errors = [];

	/**
	 * Stores custom error message to use
	 * during validation. Where 'key' is the alias.
	 *
	 * @var array
	 */
	protected $customErrors = [];

    /**
     * @var \Config\Validation
     */
    protected $config;

    protected $view;

	//--------------------------------------------------------------------

	/**
	 * Validation constructor.
	 *
	 * @param \Config\Validation $config
     * @param RenderableInterface $view
	 */
	public function __construct($config, RendererInterface $view)
	{
		$this->ruleSetFiles = $config->ruleSets;

        $this->config = $config;

        $this->view = $view;
	}

	//--------------------------------------------------------------------

	/**
	 * Runs the validation process, returning true/false determining whether
	 * or not validation was successful.
	 *
	 * @param array  $data  The array of data to validate.
	 * @param string $group The pre-defined group of rules to apply.
	 *
	 * @return bool
	 */
	public function run(array $data = null, string $group = null): bool
	{
	    $data = $data ?? $this->data;

		$this->loadRuleSets();

        $this->loadRuleGroup($group);

		// Run through each rule. If we have any field set for
		// this rule, then we need to run them through!
		foreach ($this->rules as $rField => $ruleString)
		{
			// Blast $ruleString apart, unless it's already an array.
			$rules = $ruleString;

			if (is_string($rules))
			{
				$rules = explode('|', $rules);
			}

			$this->processRules($rField, $data[$rField] ?? null, $rules, $data);
		}

		return count($this->errors) > 0
			? false
			: true;
	}

	//--------------------------------------------------------------------

	/**
	 * Runs all of $rules against $field, until one fails, or
	 * all of them have been processed. If one fails, it adds
	 * the error to $this->errors and moves on to the next,
	 * so that we can collect all of the first errors.
	 *
	 * @param            $value
	 * @param array|null $rules
	 * @param array      $data // All of the fields to check.
	 *
	 * @return bool
	 */
	protected function processRules(string $field, $value, $rules = null, array $data)
	{
		foreach ($rules as $rule)
		{
			$callable = is_callable($rule);
            $passed   = false;

			// Rules can contain parameters: max_length[5]
			$param = false;
			if (! $callable && preg_match('/(.*?)\[(.*)\]/', $rule, $match))
			{
				$rule  = $match[1];
				$param = $match[2];
			}

			// Placeholder for custom errors from the rules.
            $error = null;

			// If it's a callable, call and and get out of here.
			if ($callable)
			{
				$passed = $param === false
					? $rule($value)
					: $rule($value, $param, $data);
			}
			else
			{
				$found = false;

				// Check in our rulesets
				foreach ($this->ruleSetInstances as $set)
				{
					if (! method_exists($set, $rule))
					{
						continue;
					}

					$found = true;

					$passed = $param === false
						? $set->$rule($value, $error)
						: $set->$rule($value, $param, $data, $error);
					break;
				}

				// If the rule wasn't found anywhere, we
				// should throw an exception so the developer can find it.
				if (! $found)
				{
					throw new \InvalidArgumentException(lang('Validation.ruleNotFound'));
				}
			}

			// Set the error message if we didn't survive.
			if ($passed === false)
			{
				$this->errors[$field] = is_null($error)
                    ? $this->getErrorMessage($rule, $field)
                    : $error;

				return false;
			}
		}


		return true;
	}

	//--------------------------------------------------------------------

	/**
	 * Takes a Request object and grabs the data to use from its
	 * POST array values.
	 *
	 * @param \CodeIgniter\HTTP\RequestInterface $request
	 *
	 * @return \CodeIgniter\Validation\Validation
	 */
	public function withRequest(RequestInterface $request): ValidationInterface
	{
		$this->data = $request->getPost() ?? [];

		return $this;
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	/**
	 * Sets an individual rule and custom error messages for a single field.
	 *
	 * The custom error message should be just the messages that apply to
	 * this field, like so:
	 *
	 *    [
	 *        'rule' => 'message',
	 *        'rule' => 'message'
	 *    ]
	 *
	 * @param string $field
	 * @param string $rule
	 * @param array  $errors
	 *
	 * @return $this
	 */
	public function setRule(string $field, string $rule, array $errors = [])
	{
		$this->rules[$field] = $rule;
		$this->customErrors  = array_merge($this->customErrors, $errors);

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Stores the rules that should be used to validate the items.
	 * Rules should be an array formatted like:
	 *
	 *    [
	 *        'field' => 'rule1|rule2'
	 *    ]
	 *
	 * The $errors array should be formatted like:
	 *    [
	 *        'field' => [
	 *            'rule' => 'message',
	 *            'rule' => 'message
	 *        ],
	 *    ]
	 *
	 * @param array $rules
	 * @param array $errors // An array of custom error messages
	 *
	 * @return \CodeIgniter\Validation\Validation
	 */
	public function setRules(array $rules, array $errors = []): ValidationInterface
	{
		$this->rules = $rules;

		if (! empty($errors))
		{
			$this->customErrors = $errors;
		}

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Returns all of the rules currently defined.
	 *
	 * @return array
	 */
	public function getRules()
	{
		return $this->rules;
	}

	//--------------------------------------------------------------------

	/**
	 * Checks to see if the rule for key $field has been set or not.
	 *
	 * @param string $field
	 *
	 * @return bool
	 */
	public function hasRule(string $field): bool
	{
		return array_key_exists($field, $this->rules);
	}

	//--------------------------------------------------------------------

    /**
     * Returns the rendered HTML of the errors as defined in $template.
     *
     * @param string $template
     *
     * @return string
     */
    public function listErrors(string $template = 'list'): string
    {
        if (! array_key_exists($template, $this->config->templates))
        {
            throw new \InvalidArgumentException($template.' is not a valid Validation template.');
        }

        return $this->view->setVar('errors', $this->getErrors())
                    ->render($this->config->templates[$template]);
    }

    //--------------------------------------------------------------------

    /**
     * Displays a single error in formatted HTML as defined in the $template view.
     *
     * @param string $field
     * @param string $template
     *
     * @return string
     */
    public function showError(string $field, string $template = 'single'): string
    {
        if (! array_key_exists($field, $this->errors))
        {
            return '';
        }

        if (! array_key_exists($template, $this->config->templates))
        {
            throw new \InvalidArgumentException($template.' is not a valid Validation template.');
        }

        return $this->view->setVar('error', $this->getError($field))
                    ->render($this->config->templates[$template]);
    }

    //--------------------------------------------------------------------


	/**
	 * Loads all of the rulesets classes that have been defined in the
	 * Config\Validation and stores them locally so we can use them.
	 */
	protected function loadRuleSets()
	{
		if (empty($this->ruleSetFiles))
		{
			throw new \RuntimeException(lang('Validation.noRuleSets'));
		}

		foreach ($this->ruleSetFiles as $file)
		{
			$this->ruleSetInstances[] = new $file();
		}
	}

	//--------------------------------------------------------------------

    /**
     * Loads custom rule groups (if set) into the current rules.
     *
     * Rules can be pre-defined in Config\Validation and can
     * be any name, but must all still be an array of the
     * same format used with setRules(). Additionally, check
     * for {group}_errors for an array of custom error messages.
     *
     * @param string|null $group
     */
    protected function loadRuleGroup(string $group = null)
    {
        if (empty($group))
        {
            return;
        }

        if (! isset($this->config->$group))
        {
            throw new \InvalidArgumentException(sprintf(lang('Validation.groupNotFound'), $group));
        }

        if (! is_array($this->config->$group))
        {
            throw new \InvalidArgumentException(sprintf(lang('Validation.groupNotArray'), $group));
        }

        $this->rules = $this->config->$group;

        // If {group}_errors exists in the config file,
        // then override our custom errors with them.
        $errorName = $group.'_errors';

        if (isset($this->config->$errorName))
        {
            $this->customErrors = $this->config->$errorName;
        }
    }

    //--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// Errors
	//--------------------------------------------------------------------

    /**
     * Checks to see if an error exists for the given field.
     *
     * @param string $field
     *
     * @return bool
     */
    public function hasError(string $field): bool
    {
        return array_key_exists($field, $this->errors);
    }

    //--------------------------------------------------------------------

	/**
	 * Returns the error(s) for a specified $field (or empty string if not set).
	 *
	 * @param string $field
	 *
	 * @return string
	 */
	public function getError(string $field): string
	{
		return array_key_exists($field, $this->errors)
			? $this->errors[$field]
			: '';
	}

	//--------------------------------------------------------------------

	/**
	 * Returns the array of errors that were encountered during
	 * a run() call. The array should be in the followig format:
	 *
	 *    [
	 *        'field1' => 'error message',
	 *        'field2' => 'error message',
	 *    ]
	 *
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors ?? [];
	}

	//--------------------------------------------------------------------

	/**
	 * Sets the error for a specific field. Used by custom validation methods.
	 *
	 * @param string $field
	 * @param string $error
	 *
	 * @return \CodeIgniter\Validation\Validation
	 */
	public function setError(string $field, string $error): ValidationInterface
	{
		$this->errors[$field] = $error;

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Attempts to find the appropriate error message
	 *
	 * @param string $rule
	 * @param string $field
	 * @param string $param
	 *
	 * @return string
	 */
	protected function getErrorMessage(string $rule, string $field, string $param = null): string
	{
		// Check if custom message has been defined by user
		if (isset($this->customErrors[$field][$rule]))
		{
			$message =  $this->customErrors[$field][$rule];
		}
		else
		{
			// Try to grab a localized version of the message...
			// lang() will return the rule name back if not found,
			// so there will always be a string being returned.
			$message = lang('Validation.'.$rule);
		}

		$message = str_replace('{field}', $field, $message);
		$message = str_replace('{param}', $param, $message);

		return $message;
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// Misc
	//--------------------------------------------------------------------

	/**
	 * Resets the class to a blank slate. Should be called whenever
	 * you need to process more than one array.
	 *
	 * @return mixed
	 */
	public function reset(): ValidationInterface
	{
		$this->data         = [];
		$this->rules        = [];
		$this->errors       = [];
		$this->customErrors = [];

		return $this;
	}

	//--------------------------------------------------------------------
}
