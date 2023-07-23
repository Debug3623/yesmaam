<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class NurseBook extends Model
{
	protected $table = 'nurse_bookings';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['id', 'customer_id', 'nurse_id', 'service_start_date', 'service_end_date', 'service_time', 'booked_for', 'total_amount', 'order_id', 'special_instruction', 'booking_date', 'booking_status', 'status'];
	protected $useTimestamps = false;

	public function getBookings($nurseId)
	{
		$sql = "SELECT nurse_bookings.*, customers.first_name AS cfname, customers.last_name AS clname, nurses.first_name AS nfname, nurses.last_name AS nlname FROM nurse_bookings LEFT JOIN customers ON customers.id = nurse_bookings.customer_id LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id WHERE nurses.id = ?";

		$query = $this->db->query($sql, [$nurseId]);
		$result = $query->getResult();
		return $result;
	}

	public function getBookings2($nurseId)
	{
		$sql = "SELECT nurse_bookings.*, customers.first_name AS cfname, customers.last_name AS clname, nurses.first_name AS nfname, nurses.last_name AS nlname FROM nurse_bookings LEFT JOIN customers ON customers.id = nurse_bookings.customer_id LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id WHERE nurse_bookings.nurse_id = ? AND nurse_bookings.status = 1 ORDER BY nurse_bookings.booking_date DESC";

		$query = $this->db->query($sql, [$nurseId]);
		$result = $query->getResult();

		$sql = "SELECT requirement_bookings.id, requirements.user_id AS customer_id, requirements.category, requirements.start_date AS service_start_date, requirements.end_date AS service_end_date, requirements.start_time AS service_time, requirements.end_time, requirements.area, requirements.details, requirements.budget, requirements.status, customers.first_name AS cfname, customers.last_name AS clname, nurses.first_name AS nfname, nurses.last_name AS nlname, requirement_bookings.amount AS total_amount, requirement_bookings.order_id, requirement_bookings.booking_date_time AS booking_date, requirement_bookings.status AS booking_status FROM requirements LEFT JOIN requirement_bookings ON requirement_bookings.requirement_id = requirements.id LEFT JOIN customers ON customers.id = requirement_bookings.customer_id LEFT JOIN nurses ON nurses.id = requirement_bookings.nurse_id WHERE requirement_bookings.nurse_id = ? AND requirement_bookings.status = 'completed' ORDER BY requirements.id DESC";
		$query = $this->db->query($sql, [$nurseId]);
		$result2 = $query->getResult();

		$rr = [];
		foreach($result2 as $r) {
			$time1 = strtotime($r->service_time);
			$time2 = strtotime($r->end_time);
			$r->booked_for = (string)round(abs($time2 - $time1) / 3600, 2);
			$rr[] = $r;
		}
		// booked_for
		$result = array_merge($result, $rr);
		return $result;
	}

	public function getCustomerBookings($customerId)
	{
		$sql = "SELECT nurse_bookings.*, customers.first_name AS cfname, customers.last_name AS clname, nurses.first_name AS nfname, nurses.last_name AS nlname FROM nurse_bookings LEFT JOIN customers ON customers.id = nurse_bookings.customer_id LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id WHERE customers.id = ? AND nurse_bookings.status = 1 ORDER BY nurse_bookings.booking_date DESC";

		$query = $this->db->query($sql, [$customerId]);
		$result = $query->getResult();
		return $result;
	}

	public function getCustomerBookings2($customerId)
	{
		$sql = "SELECT nurse_bookings.*, customers.first_name AS cfname, customers.last_name AS clname, nurses.first_name AS nfname, nurses.last_name AS nlname, customers.profile_photo FROM nurse_bookings LEFT JOIN customers ON customers.id = nurse_bookings.customer_id LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id WHERE customers.id = ? AND nurse_bookings.booking_status = 'completed' ORDER BY nurse_bookings.booking_date DESC";

		$query = $this->db->query($sql, [$customerId]);
		$result = $query->getResult();
		return $result;
	}

	public function getAllNurses()
	{
		$sql = "
		SELECT
		    nurse_bookings.*,
		    nurses.first_name AS dfname,
		    nurses.last_name AS dlname,
		    nurses.email,
		    main_categories.name AS cname,
		    customers.first_name AS cfname,
		    customers.last_name AS clname
		FROM
		    nurse_bookings
		LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id
		LEFT JOIN main_categories ON main_categories.id = nurses.category
		LEFT JOIN customers ON customers.id = nurse_bookings.customer_id ORDER BY nurse_bookings.id DESC
		";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
  
  	public function getSingleNurseBooking($id)
	{
		$sql = "SELECT nurse_bookings.*, customers.mobile AS c_mobile, nurses.first_name AS nurse_firstname, nurses.last_name AS nurse_lastname, nurses.photo AS n_photo, orders.order_date, orders.payment_type, orders.billing_firstname, orders.billing_lastname, orders.billing_email, orders.billing_address, orders.billing_city, orders.payment_status, orders.amount FROM nurse_bookings LEFT JOIN orders ON orders.id = nurse_bookings.order_id LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id LEFT JOIN customers ON customers.id = nurse_bookings.customer_id WHERE nurse_bookings.id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
		
		return $result;
	}
}