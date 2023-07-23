<?php

namespace App\Models\Api; 



use CodeIgniter\Model;



class Nurse extends Model

{

	protected $table = 'nurses';

	protected $primaryKey = 'id';

	protected $returnType = 'object';

	protected $allowedFields = ['first_name', 'middle_name', 'last_name', 'email', 'phone', 'work_title', 'about', 'expertise', 'category', 'working_hours', 'date_of_birth', 'marital_status', 'skills', 'visa_type', 'photo', 'working_type', 'nationality', 'experience', 'city', 'address', 'EID', 'passport_no', 'passport', 'user_id', 'confirmed', 'status', 'speaking_languages', 'gender', 'nurse_from', 'available'];

	protected $useTimestamps = true;



	public function getAllNurses($cate = null)

	{

		$sql = "SELECT nurses.*, main_categories.id AS cate_id, name AS cate_name FROM nurses LEFT JOIN main_categories ON main_categories.id = nurses.category";



		if($cate) {
			$sql .= " WHERE nurses.category = ? AND nurses.status = 1 AND nurses.confirmed = 1 AND nurses.nurse_from = 'app' AND nurses.available = 'Yes'";
			$query = $this->db->query($sql, [$cate]);
		}
		else {
			$sql .= " WHERE nurses.status = 1 AND nurses.confirmed = 1 AND nurses.nurse_from = 'app' AND nurses.available = 'Yes'";
			$query = $this->db->query($sql);
		}



		$result = $query->getResult();

		return $result;

	}
	
	public function getAllNursesWithLatLong($cate = null)
	{
		$sql = "SELECT nurses.*, users.longitude, users.latitude, main_categories.id AS cate_id, main_categories.name AS cate_name FROM nurses LEFT JOIN main_categories ON main_categories.id = nurses.category LEFT JOIN users ON users.id = nurses.user_id";

		if($cate) {
			$sql .= " WHERE nurses.category = ? AND nurses.status = 1 AND nurses.confirmed = 1 AND nurses.available = 'Yes'";
			$query = $this->db->query($sql, [$cate]);
		}
		else {
			$sql .= " WHERE nurses.status = 1 AND nurses.confirmed = 1 AND nurses.available = 'Yes'";
			$query = $this->db->query($sql);
		}

		$result = $query->getResult();
		return $result;
	}
}