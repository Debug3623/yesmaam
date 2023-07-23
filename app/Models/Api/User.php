<?php

namespace App\Models\Api;



use CodeIgniter\Model;



class User extends Model

{

	protected $table = 'users';

	protected $primaryKey = 'id';

	protected $returnType = 'object';

	protected $allowedFields = ['name', 'email', 'username', 'phone', 'password', 'user_type', 'registration_id', 'email_verified', 'phone_verified', 'latitude', 'longitude', 'status'];

	protected $useTimestamps = false;

	

	public function isUnique(int $phone): bool

	{

		$sql = "SELECT * FROM users WHERE phone = ?";

		$query = $this->db->query($sql, $phone);

		if($query->getResult()) {

			return true;

		}

		return false;

	}

}