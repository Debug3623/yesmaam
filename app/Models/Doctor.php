<?php
namespace App\Models;

use CodeIgniter\Model;

class Doctor extends Model
{
	protected $table = 'doctors';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['first_name', 'middle_name', 'last_name', 'mobile', 'dob', 'address', 'email', 'about_you', 'specialities', 'category', 'speaking_languages', 'photo', 'city', 'document', 'experience', 'user_id', 'channel_id', 'confirmed', 'status', 'available'];
	protected $useTimestamps = false;

	public function getHomeDoctor()
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.confirmed = 1 AND doctors.doctor_from = 'web'";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}

	public function getDoctors($confirmed = null)
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category ";

		if($confirmed) {
			$sql .= " WHERE doctors.confirmed = 1 AND doctors.doctor_from = 'web'";
		}
		else {
			$sql .= "doctors.doctor_from = 'web'";
		}
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
		
	public function getCustomers()
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.doctor_from = 'web'";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}

	public function getSingleDoctor($id)
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
		return $result;
	}

	public function getSimilarDoctors($cate, $current_id)
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.category = ? AND doctors.id != ? AND doctors.doctor_from = 'web' LIMIT 6";
		$query = $this->db->query($sql, [$cate, $current_id]);
		$result = $query->getResult();
		return $result;
	}

	public function searchDoctors($where)
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.confirmed = 1 AND doctors.doctor_from = 'web' AND ";

		//if() {
			
		//}
		$x = 0;
		foreach($where as $k => $v) {
			$sql .= $k . " = '$v'";

			$x++;

			if(next($where)) {
				$sql .= " AND ";
				
			}
		}

		//dd($sql);
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
}