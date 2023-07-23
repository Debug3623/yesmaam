<?php
namespace App\Models; 

use CodeIgniter\Model;

class EmailVerification extends Model
{
	protected $table = 'email_verifications';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['email', 'code', 'date'];
	protected $useTimestamps = false;
}