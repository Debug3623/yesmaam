<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class Referral extends Model
{
	protected $table = 'referrals';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['user_id', 'referral_code'];
	protected $useTimestamps = false;
}