<?php 
namespace App\Models;

use CodeIgniter\Model;

class AdminsModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'Id';
    protected $returnType = 'App\Entities\Admins';
    protected $allowedFields = ['Username', 'Email', 'Password', 'Auth', 'Status'];
}