<?php

namespace App\Models\Api;



use CodeIgniter\Model;



class Doctor extends Model

{

	protected $table = 'doctors';

	protected $primaryKey = 'id';

	protected $returnType = 'object';

	protected $allowedFields = ['first_name', 'middle_name', 'last_name', 'mobile', 'dob', 'address', 'email', 'about_you', 'specialities', 'category', 'speaking_languages', 'photo', 'city', 'document', 'experience', 'user_id', 'channel_id', 'confirmed', 'status', 'available', 'gender', 'doctor_from'];

	protected $useTimestamps = false;



	public function getAllDoctors($cate = null)

	{

		$sql = "SELECT doctors.*, main_categories.id AS cate_id, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category";



		if($cate) {
			$sql .= " WHERE doctors.category = ? AND doctors.confirmed = 1 AND doctors.status = 1 AND available = 'Yes' AND doctors.doctor_from = 'app'";
			$query = $this->db->query($sql, [$cate]);
		}
		else {
			$sql .= " WHERE doctors.confirmed = 1 AND doctors.status = 1 AND available = 'Yes' AND doctors.doctor_from = 'app'";
			$query = $this->db->query($sql);
		}

		$result = $query->getResult();

		return $result;

	}

}