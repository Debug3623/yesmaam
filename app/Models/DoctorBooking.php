<?php
namespace App\Models; 

use CodeIgniter\Model;

class DoctorBooking extends Model
{
	protected $table = 'doctor_bookings';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['customer_id', 'meeting_link', 'doctor_id', 'service_date', 'service_time', 'booked_for', 
                                'booking_date', 'order_id', 'insurance_no', 'emirates_id', 'status', 'prescription','remarks'];
	protected $useTimestamps = false;

	public function getBookings($nurseId)
	{
		$sql = "SELECT doctor_bookings.*, customers.first_name AS cfname, customers.mobile AS cphone, customers.last_name AS clname, doctors.first_name AS nfname, doctors.last_name AS nlname FROM doctor_bookings LEFT JOIN customers ON customers.id = doctor_bookings.customer_id LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id WHERE doctors.id = ?";

		$query = $this->db->query($sql, [$nurseId]);
		$result = $query->getResult();
		return $result;
	}

	public function getCustomerBookings($customerID)
	{
		$sql = "SELECT doctor_bookings.*, customers.first_name AS cfname, customers.mobile AS cphone, customers.last_name AS clname, doctors.first_name AS nfname, doctors.last_name AS nlname FROM doctor_bookings LEFT JOIN customers ON customers.id = doctor_bookings.customer_id LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id WHERE customers.id = ? ORDER BY doctor_bookings.booking_date DESC";

		$query = $this->db->query($sql, [$customerID]);
		$result = $query->getResult();
		return $result;
	}

	public function getAllDoctors()
	{
		$sql = "
		SELECT
		    doctor_bookings.*,
		    doctors.first_name AS dfname,
		    doctors.last_name AS dlname,
		    customers.mobile AS cphone, 
		    doctors.email,
		    main_categories.name AS cname,
		    customers.first_name AS cfname,
		    customers.last_name AS clname
		FROM
		    doctor_bookings
		LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id
		LEFT JOIN main_categories ON main_categories.id = doctors.category
		LEFT JOIN customers ON customers.id = doctor_bookings.customer_id ORDER BY doctor_bookings.id DESC
		";
		$query = $this->db->query($sql);
		$result = $query->getResult();
		return $result;
	}
	
	public function getSingleDoctorBooking($id)
	{
		$sql = "SELECT doctor_bookings.*, customers.mobile AS c_mobile, doctors.first_name AS doctor_firstname, doctors.last_name AS doctor_lastname, doctors.photo AS n_photo, orders.order_date, orders.payment_type, orders.billing_firstname, orders.billing_lastname, orders.billing_email, orders.billing_address, orders.billing_city, orders.payment_status, orders.amount FROM doctor_bookings LEFT JOIN orders ON orders.id = doctor_bookings.order_id LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id LEFT JOIN customers ON customers.id = doctor_bookings.customer_id WHERE doctor_bookings.id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
		
		return $result;
	}
	
		public function download($id){
		    
		    	$sql = "SELECT * from doctor_bookings WHERE id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
	
			return $result;
		}
}