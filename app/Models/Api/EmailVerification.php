<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class EmailVerification extends Model
{
	protected $table = 'email_verifications';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['email', 'phone', 'code', 'date'];
	protected $useTimestamps = false;
}