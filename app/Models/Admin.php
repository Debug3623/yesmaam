<?php
namespace App\Models;

use CodeIgniter\Model;

class Admin extends Model
{
	protected $table = 'admin';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'name', 'email', 'phone', 'username', 'password', 'type', 'status'
	];
	protected $returnType = 'object';
	protected $useTimestamps = false;
}