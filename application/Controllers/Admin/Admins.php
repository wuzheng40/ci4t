<?php 
namespace App\Controllers\Admin;

use App\Models\AdminsModel;

class Admins extends \CodeIgniter\Controller
{	
	/**
	 * pagesize is paginate size
	 */
	private $pagesize = 30;
	private $Admins;

	public function __construct()
	{
		helper('url');
	 	$this->Admins = new AdminsModel();
	}

	/**
	 * List all
	 */
	public function listAll()
	{
		$returndata['header'] = 'Admins';
		$request = \Config\Services::request();
		$where = [];
		$data = $request->getGet();

		if(isset($data['search_Id']) && !empty($data['search_Id']))
		{
			$where['Id'] = $data['search_Id'];
		}
		if(isset($data['search_Username']) && !empty($data['search_Username']))
		{
			$where['Username'] = $data['search_Username'];
		}
		if(isset($data['search_Email']) && !empty($data['search_Email']))
		{
			$where['Email'] = $data['search_Email'];
		}
		if(isset($data['search_Password']) && !empty($data['search_Password']))
		{
			$where['Password'] = $data['search_Password'];
		}
		if(isset($data['search_Auth']) && !empty($data['search_Auth']))
		{
			$where['Auth'] = $data['search_Auth'];
		}
		if(isset($data['search_Status']) && !empty($data['search_Status']))
		{
			$where['Status'] = $data['search_Status'];
		}

		$returndata['data'] = $this->Admins->where($where)->orderBy('Id', 'desc')->paginate($this->pagesize);
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
	
	/**
	 * Update item
	 * @var string
	 */
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
