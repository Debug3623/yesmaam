<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class Plan extends Model
{
	protected $table = 'plans';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['title', 'description', 'symbol','price'];
	protected $useTimestamps = false;
}