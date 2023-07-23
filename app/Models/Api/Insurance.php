<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class Insurance extends Model
{
	protected $table = 'insurances';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['title'];
	protected $useTimestamps = false;
}
