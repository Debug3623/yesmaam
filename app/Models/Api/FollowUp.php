<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class FollowUp extends Model
{
	protected $table = 'follow_ups';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['doctor_id','user_id','remark', 'file','status', 'follow_date','token','channel_id','prescription'];
	protected $useTimestamps = false;
	
	
	public function getFollowUp($id,$type)
    {
        if($type == 'doctor') {
            $sql = "SELECT follow_ups.*, customers.user_id, customers.first_name AS c_fname, 
            customers.last_name AS c_lname, customers.user_id, doctors.first_name AS d_fname, 
            doctors.last_name AS d_lname, users.registration_id
            FROM follow_ups 
            LEFT JOIN customers ON customers.user_id = follow_ups.user_id 
            LEFT JOIN doctors ON doctors.id = follow_ups.doctor_id 
            LEFT JOIN users ON users.id = customers.user_id WHERE follow_ups.id = ?";
        }
        else {
            $sql = "SELECT follow_ups.*, customers.user_id, customers.first_name AS c_fname, 
            customers.last_name AS c_lname, customers.user_id, doctors.first_name AS d_fname, 
            doctors.last_name AS d_lname, users.registration_id
            FROM follow_ups 
            LEFT JOIN customers ON customers.user_id = follow_ups.user_id 
            LEFT JOIN doctors ON doctors.id = follow_ups.doctor_id 
            LEFT JOIN users ON users.id = doctors.user_id WHERE follow_ups.id = ?";
        }
       
        $query = $this->db->query($sql, [$id]);
        $result = $query->getRow();
        return $result;
    }
}
