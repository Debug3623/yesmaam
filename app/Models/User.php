<?php
namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['name', 'email', 'username', 'phone', 'password', 'user_type', 'email_verified', 'status'];
	protected $useTimestamps = false;
}