<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdminsModel;
use App\Entities\Admins;

class Home extends Controller
{
	public function index()
	{
		//throw new \CodeIgniter\PageNotFoundException('home');
		return view('welcome_message');
	}

	public function d()
	{
		phpinfo();
	}

	public function out()
	{

		echo 's';
		$model = new AdminsModel();
		$entities = new Admins();
		//$entities->Id = 31;
		$entities->Username = 'UT127';
		$entities->Email = 'UT127@ubi.com';
		$entities->Password = 'UT123456';
		$entities->Auth = 'Admin';
		$entities->Status = 1;
		echo $model->save($entities);
	}

	public function u()
	{
		echo 'u';
	}
	public function b()
	{
		echo 'b';
	}
	//--------------------------------------------------------------------

}
