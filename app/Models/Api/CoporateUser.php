<?php

namespace App\Models\Api;



use CodeIgniter\Model;



class CoporateUser extends Model

{
    

	protected $table = 'coporate_users';

	protected $primaryKey = 'id';

	protected $returnType = 'object';

	protected $allowedFields = ['company_name', 'company_address', 'company_email','profile_status', 'mobile', 'user_id', 'document', 'confirmed', 'available', 'status','first_name','last_name','about','city','image'];

	protected $useTimestamps = false;

	

	public function isUnique(int $phone): bool

	{

		$sql = "SELECT * FROM coporate_users WHERE mobile = ?";

		$query = $this->db->query($sql, $phone);

		if($query->getResult()) {

			return true;

		}

		return false;

	}

}