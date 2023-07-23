<?php
namespace App\Models; 

use CodeIgniter\Model;

class NurseBook extends Model
{
	protected $table = 'nurse_bookings';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['id', 'customer_id', 'nurse_id', 'service_start_date', 'service_end_date', 'service_time', 'booked_for', 'total_amount', 'order_id', 'special_instruction', 'status'];
	protected $useTimestamps = false;

	public function getBookings($nurseId)
	{
		$sql = "SELECT nurse_bookings.*, customers.first_name AS cfname, customers.last_name AS clname, nurses.first_name AS nfname, nurses.last_name AS nlname FROM nurse_bookings LEFT JOIN customers ON customers.id = nurse_bookings.customer_id LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id WHERE nurses.id = ?";

		$query = $this->db->query($sql, [$nurseId]);
		$result = $query->getResult();
		return $result;
	}

	public function getCustomerBookings($customerId)
	{
		$sql = "SELECT nurse_bookings.*, customers.first_name AS cfname, customers.last_name AS clname, nurses.first_name AS nfname, nurses.last_name AS nlname FROM nurse_bookings LEFT JOIN customers ON customers.id = nurse_bookings.customer_id LEFT JOIN nurses ON nurses.id = nurse_bookings.nurse_id WHERE customers.id = ? AND nurse_bookings.status = 1 ORDER BY nurse_bookings.booking_date DESC";

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