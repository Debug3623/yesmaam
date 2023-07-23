<?php

namespace App\Models\Api; 



use CodeIgniter\Model;



class Customer extends Model

{

	protected $table = 'customers';

	protected $primaryKey = 'id';

	protected $returnType = 'object';

	protected $allowedFields = ['first_name', 'middle_name', 'last_name', 'email', 'mobile', 'address', 'profile_photo', 'emirates_pc', 'insurance_pc', 'insurance_status', 'emirates_status', 'user_id', 'status', 'dob', 'visa_status', 'emirates_id', 'emirates_expiry', 'nationality', 'insurance_company', 'passport_no', 'city', 'insurance_id', 'gender'];

	protected $useTimestamps = true;



	public function getCustomers()

	{

		$sql = "SELECT customers.* FROM customers";

		$query = $this->db->query($sql);

		$result = $query->getResult();

		return $result;

	}

}