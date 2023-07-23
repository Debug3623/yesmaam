<?php
namespace App\Models\Admin;

use CodeIgniter\Model;

class CoporateUser extends Model
{
	protected $table = 'coporate_users';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['first_name', 'middle_name','last_name','company_name','company_address','company_email','about','image', 'last_name', 'mobile', 'dob', 'address', 'email', 'about_you', 'specialities', 'category', 'speaking_languages', 'photo', 'city', 'document', 'experience', 'user_id', 'channel_id', 'confirmed', 'status', 'available', 'doctor_from'];
	protected $useTimestamps = false;

	public function getHomeDoctor()
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.confirmed = 1";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
	
	
		public function getCorporateUsers()
	{
		$sql = "SELECT coporate_users.id,coporate_users.user_id,referrals.referral_code,purchase_plans.payment_status,coporate_users.first_name,coporate_users.last_name,coporate_users.mobile,coporate_users.company_name,coporate_users.confirmed,coporate_users.confirmed,available,coporate_users.status FROM users 
		RIGHT JOIN coporate_users ON coporate_users.user_id = users.id
	    LEFT JOIN purchase_plans ON purchase_plans.user_id = users.id
	    LEFT JOIN referrals ON referrals.user_id = users.id";
	    //LEFT JOIN  orders ON  orders.customer_id = customers.id";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
	
	
		public function getCorporateEmployee()
	{
		$sql = "SELECT COUNT(employees.id)as employee,employees.confirmed,coporate_users.user_id,
		coporate_users.first_name,coporate_users.last_name,coporate_users.mobile,coporate_users.company_name,available,coporate_users.status,employees.confirmed
		FROM coporate_users 
		RIGHT JOIN employees ON employees.company_code = coporate_users.user_id 
      
		GROUP BY employees.company_code
		";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
	
			public function getCorporateEmployees()
	{
		$sql = "SELECT COUNT(employees.id)as employee,COUNT(employees.confirmed)as user_confirmed,coporate_users.user_id,
		coporate_users.first_name,coporate_users.last_name,coporate_users.mobile,coporate_users.company_name,available,coporate_users.status,employees.confirmed
		FROM coporate_users 
		RIGHT JOIN employees ON employees.company_code = coporate_users.user_id 
     	WHERE employees.confirmed = 1
		GROUP BY employees.company_code
		";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
	
				public function getCorporate($id)
	{
		$sql = "SELECT coporate_users.id,company_address,company_email,company_address,coporate_users.city,image,about,coporate_users.user_id,
		coporate_users.first_name,coporate_users.last_name,coporate_users.mobile,coporate_users.company_name,available,coporate_users.status,plans.title,referrals.referral_code
		FROM coporate_users 
        LEFT JOIN purchase_plans ON purchase_plans.user_id = coporate_users.user_id 
        LEFT JOIN plans ON plans.id = purchase_plans.plan_id 
        LEFT JOIN referrals ON referrals.user_id = coporate_users.user_id 
		WHERE coporate_users.id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
			return $result;
	}
	
	
		public function getEmployeeBilling()
	{
		$sql = "SELECT purchase_plans.id,purchase_plans.total_price,purchase_plans.start_date,
		purchase_plans.end_date,purchase_plans.payment_status,coporate_users.first_name,coporate_users.last_name,
		coporate_users.mobile,coporate_users.company_name,coporate_users.confirmed,coporate_users.confirmed,
		available,coporate_users.status FROM purchase_plans 
		LEFT JOIN coporate_users ON coporate_users.user_id = purchase_plans.user_id";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
	
		public function getSinglePlanBooking($id)
	{
		$sql = "SELECT purchase_plans.id,purchase_plans.total_price,purchase_plans.start_date,plans.title,
		plans.employee as plan_employee,purchase_plans.employee as total_employee,
		purchase_plans.end_date,purchase_plans.payment_status,coporate_users.first_name,coporate_users.last_name,
		coporate_users.mobile,coporate_users.company_name,coporate_users.company_email ,city,company_address,coporate_users.confirmed,coporate_users.confirmed,
		available,coporate_users.status FROM purchase_plans 
		LEFT JOIN coporate_users ON coporate_users.user_id = purchase_plans.user_id 
		LEFT JOIN plans ON plans.id = purchase_plans.plan_id 

		WHERE purchase_plans.id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
		
		return $result;
	}
	
			public function getCustomersCorporate($id)
	{
		$sql = "SELECT employees.id,employees.fname,employees.lname,employees.mobile,
		employees.id_number,employees.insurance_status FROM employees 
		LEFT JOIN coporate_users ON coporate_users.user_id = employees.company_code WHERE coporate_users.user_id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getResult();
		
		return $result;
	}
	
	

	public function getDoctors($confirmed = null)
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category ";

		if($confirmed) {
			$sql .= " WHERE doctors.confirmed = 1 AND doctors.doctor_from = 'web'";
		}
		
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
		
	public function getCustomers()
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category";
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
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.category = ? AND doctors.id != ? LIMIT 6";
		$query = $this->db->query($sql, [$cate, $current_id]);
		$result = $query->getResult();
		return $result;
	}

	public function searchDoctors($where)
	{
		$sql = "SELECT doctors.*, main_categories.name AS cate_name FROM doctors LEFT JOIN main_categories ON main_categories.id = doctors.category WHERE doctors.confirmed = 1 AND ";

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