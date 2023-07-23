<?php
namespace App\Models\Api;

use CodeIgniter\Model;

class MobileVerification extends Model
{
	protected $table = "mobile_verifications";
	protected $primaryKey = "id";
	protected $returnType = "object";
	protected $allowedFields = [
		'user_id', 'mobile', 'code', 'date_time', 'status'	
	];
	protected $useTimestamps = false;
}