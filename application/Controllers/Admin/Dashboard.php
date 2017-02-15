<?php 
namespace App\Controllers\Admin;

use App\Models\AdminsModel;
use App\Entities\Admins;

class Dashboard extends \CodeIgniter\Controller
{	
	public function __construct()
	{
		helper('url');
	}

	public function index()
	{
		//echo \Config\Services::renderer()->renderString('<div>My Sharona</div>');
		return view('admin/Dashboard');
	}

	public function admin()
	{
		return view('admin/Admin');
	}

	public function getn()
	{
		return '<br><br><br><br><br><br>t';
	}

	public function login()
	{
		helper('url');		
		return view('admin/Login');
	}
}
