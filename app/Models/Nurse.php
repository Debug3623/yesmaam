<?php
namespace App\Models; 

use CodeIgniter\Model;

class Nurse extends Model
{
	protected $table = 'nurses';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['first_name', 'middle_name', 'last_name', 'email', 'phone', 'work_title', 'about', 'expertise', 'category', 'working_hours', 'date_of_birth', 'marital_status', 'skills', 'visa_type', 'photo', 'working_type', 'nationality', 'experience', 'city', 'address', 'EID', 'passport_no', 'passport', 'user_id', 'confirmed', 'status'];
	protected $useTimestamps = true;

	public function getHomeNurses()
	{
		$sql = "SELECT nurses.*, main_categories.name AS cate_name FROM nurses LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE nurses.confirmed = 1 AND nurses.nurse_from = 'web'";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
	
  	public function getNurses($confirmed = null)
	{
		$sql = "SELECT nurses.*, main_categories.name AS cate_name FROM nurses LEFT JOIN main_categories ON main_categories.id = nurses.category";
		if($confirmed) {
			$sql .= " WHERE nurses.confirmed = 1 AND nurses.nurse_from = 'web'";
		}
		else {
			$sql .= " WHERE nurses.nurse_from = 'web'";
		}
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}

	public function getSingleNurse($id)
	{
		$sql = "SELECT nurses.*, main_categories.name AS cate_name FROM nurses LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE nurses.id = ? AND nurses.nurse_from = 'web'";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
		return $result;
	}

	public function getSimilarNurses($cate, $current_id)
	{
		$sql = "SELECT nurses.*, main_categories.name AS cate_name FROM nurses LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE nurses.category = ? AND nurses.id != ? AND nurses.nurse_from = 'web' LIMIT 6";
		$query = $this->db->query($sql, [$cate, $current_id]);
		$result = $query->getResult();
		return $result;
	}

	public function searchNurses($where)
	{
		$sql = "SELECT nurses.*, main_categories.name AS cate_name FROM nurses LEFT JOIN main_categories ON main_categories.id = nurses.category WHERE nurses.confirmed = 1 AND nurses.nurse_from = 'web' AND ";

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