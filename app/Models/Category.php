<?php
namespace App\Models; 

use CodeIgniter\Model;

class Category extends Model
{
	protected $table = 'main_categories';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['name', 'cate_for', 'status'];
	protected $useTimestamps = false;
}