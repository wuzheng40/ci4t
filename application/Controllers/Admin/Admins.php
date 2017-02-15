<?php 
namespace App\Controllers\Admin;

use App\Models\AdminsModel;
use App\Entities\Admins as ads;

class Admins extends \CodeIgniter\Controller
{	
	/**
	 * pagesize is paginate size
	 * Admins is model data
	 */
	private $pagesize = 10;
	private $Admins;

	public function __construct()
	{
		helper('url');
	 	$this->Admins = new AdminsModel();
	}

	public function index()
	{
		return 'index';
	}

	/**
	 * List all
	 */
	public function listAll()
	{	
		//$returndata['data'] = $this->Admins->where(['Auth'  => 'Admin','Status' => 1])->paginate($this->pagesize);
		$returndata['data'] = $this->Admins->paginate($this->pagesize);
		$returndata['pager'] = $this->Admins->pager;
		return view('admin/Admin', $returndata);
	}
	
	/**
	 * Display detail
	 * @var string
	 */
	public function show($id = null)
	{	
		if ($id)
		{
			$data = $this->Admins->find($id);
			if ($data)
			{
				$return = ['code' => 1, 'message' => 'Success!', 'data' => $data];
			}
			else
			{
				$return = ['code' => 2, 'message' => 'Fail!'];
			}
		}
		else
		{
			$return = ['code' => 3, 'message' => 'No Id!!'];
		}

		echo json_encode($return);
	}
	
	/**
	 * Add item
	 * @formobject post
	 */
	public function create()
	{	
		$request = \Config\Services::request();
		$data = $request->getPost();

		unset($data['Id']);
		$id = $this->Admins->save($data);
		if ($id)
		{
			$return = ['code' => 1, 'message' => 'Success!', 'id' => $id];
		}
		else
		{
			$return = ['code' => 2, 'message' => 'Fail!'];
		}

		echo json_encode($return);
	}
	
	public function update($id)
	{		
		$request = \Config\Services::request();
		$data = $request->getRawInput();

		if ($this->Admins->save($data))
		{
			$return = ['code' => 1, 'message' => 'Success!'];
		}
		else
		{
			$return = ['code' => 2, 'message' => 'Fail!'];
		}
		
		echo json_encode($return);
	}
	
	/**
	 * Delete item
	 * @var string
	 */
	public function delete($id)
	{
		if ($id)
		{
			if ($this->Admins->delete($id))
			{
				$return = ['code' => 1, 'message' => 'Success!'];
			}
			else
			{
				$return = ['code' => 2, 'message' => 'Fail!'];
			}
		}
		else
		{
			$return = ['code' => 3, 'message' => 'No Id!!'];
		}

		echo json_encode($return);
	}
}
