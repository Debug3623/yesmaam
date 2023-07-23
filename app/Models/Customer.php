<?php
namespace App\Models; 

use CodeIgniter\Model;

class Customer extends Model
{
	protected $table = 'customers';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['first_name', 'last_name', 'middle_name', 'email', 'password', 'mobile', 'address', 'user_id', 'profile_photo', 'emirates_pc', 'insurance_pc', 'insurance_status', 'emirates_status', 'status', 'dob', 'visa_status', 'emirates_id', 'emirates_expiry', 'nationality', 'insurance_company', 'passport_no', 'city', 'insurance_id'];
	protected $useTimestamps = true;

	public function getCustomers()
	{
		$sql = "SELECT customers.* FROM customers";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
}