<?php namespace App\Controllers;

use CodeIgniter\Controller;

class R extends Controller
{
	public function __construct()
    {
    }

	public function index()
	{
		echo 'index';
	}

	public function listAll()
	{
		echo 'listAll';
	}
	
	public function show($id)
	{
		echo 'show';
	}
	
	public function create()
	{
		echo 'create';
	}
	
	public function update($id)
	{
		echo 'update';
	}
	
	public function delete($id)
	{
		echo 'delete';
	}

	//--------------------------------------------------------------------

}
