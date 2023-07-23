<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class DoctorBooking extends Model
{
	protected $table = 'doctor_bookings';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['customer_id','user_id' ,'remarks','meeting_link', 'doctor_id','free_leave','dha_leave','delivery_medicine', 'service_date', 'service_time', 'booked_for', 'booking_date', 'call_type', 'order_id', 'insurance_no', 'emirates_id', 'token','filename', 'status', 'prescription', 'appointment', 'channel_id'];
	protected $useTimestamps = false;
	
	public function getBooking($id, $type)
    {
        if($type == 'doctor') {
            $sql = "SELECT doctor_bookings.*, customers.user_id, customers.first_name AS c_fname, 
            customers.last_name AS c_lname, customers.user_id, doctors.first_name AS d_fname, 
            doctors.last_name AS d_lname, users.registration_id
            FROM doctor_bookings LEFT JOIN customers ON customers.id = doctor_bookings.customer_id 
            LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id LEFT JOIN users 
            ON users.id = customers.user_id WHERE doctor_bookings.order_id = ?";
        }
        else {
            $sql = "SELECT doctor_bookings.*, customers.user_id, customers.first_name AS c_fname, 
            customers.last_name AS c_lname, customers.user_id, doctors.first_name AS d_fname, 
            doctors.last_name AS d_lname, users.registration_id
            FROM doctor_bookings LEFT JOIN customers ON customers.id = doctor_bookings.customer_id 
            LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id LEFT JOIN users 
            ON users.id = doctors.user_id WHERE doctor_bookings.order_id = ?";
        }
       
        $query = $this->db->query($sql, [$id]);
        $result = $query->getRow();
        return $result;
    }
    
    
    public function getEmployeeBooking($id, $type)
    {
        if($type == 'doctor') {
            $sql = "SELECT doctor_bookings.*, employees.user_id, employees.fname AS c_fname, 
            employees.lname AS c_lname, employees.user_id, doctors.first_name AS d_fname, 
            doctors.last_name AS d_lname, users.registration_id
            FROM doctor_bookings LEFT JOIN employees ON employees.user_id = doctor_bookings.user_id 
            LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id LEFT JOIN users 
            ON users.id = employees.user_id WHERE doctor_bookings.id = ?";
        }
        else {
            $sql = "SELECT doctor_bookings.*, employees.user_id, employees.fname AS c_fname, 
            employees.lname AS c_lname, employees.user_id, doctors.first_name AS d_fname, 
            doctors.last_name AS d_lname, users.registration_id
            FROM doctor_bookings LEFT JOIN employees ON employees.user_id = doctor_bookings.user_id 
            LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id LEFT JOIN users 
            ON users.id = doctors.user_id WHERE doctor_bookings.id = ?";
        }
       
        $query = $this->db->query($sql, [$id]);
        $result = $query->getRow();
        return $result;
    }



	function isDoctorAvailable($dr_id, $date, $time)
    {
        $previous = date('H:i:s', strtotime($time) - 5400);
        $next = date('H:i:s', strtotime($time) + 5400);

        $sql = "SELECT COUNT(*) as count FROM doctor_bookings WHERE service_date = ? AND doctor_id = ? AND service_time < ? AND  service_time > ?";
        $query = $this->db->query($sql, [$date, $dr_id, $previous, $next]);
        $result = $query->getResult();
        if($result) {
            return true;
        }
        return false;
    }
    
    public function getAllBookingsCustomers($id, $type = 'customer') {
        
        $sql = "SELECT doctor_bookings.*, customers.user_id, customers.first_name AS c_fname, 
        customers.last_name AS c_lname, customers.profile_photo, doctors.first_name AS d_fname, 
        doctors.last_name AS d_lname, doctors.photo, orders.billing_firstname, 
        orders.billing_lastname, orders.billing_email, orders.billing_address, 
        orders.billing_city, orders.billing_country_code
         FROM doctor_bookings 
        LEFT JOIN customers ON customers.id = doctor_bookings.customer_id 
        LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id
        LEFT JOIN orders ON orders.id = doctor_bookings.order_id WHERE doctor_bookings.customer_id = ? ORDER BY doctor_bookings.booking_date DESC";
        $query = $this->db->query($sql, [$id]);
        $result = $query->getResult();
        return $result;
    }
    
    
        public function getAllBookingsEmployee($id, $type = 'employee') {
        
        $sql = "SELECT doctor_bookings.*, employees.user_id, employees.fname AS c_fname, 
        employees.lname AS c_lname, employees.image, doctors.first_name AS d_fname, 
        doctors.last_name AS d_lname, doctors.photo, orders.billing_firstname, 
        orders.billing_lastname, orders.billing_email, orders.billing_address, 
        orders.billing_city, orders.billing_country_code
         FROM doctor_bookings 
        LEFT JOIN employees ON employees.user_id = doctor_bookings.user_id 
        LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id
        LEFT JOIN orders ON orders.id = doctor_bookings.order_id WHERE doctor_bookings.user_id = ? ORDER BY doctor_bookings.booking_date DESC";
        $query = $this->db->query($sql, [$id]);
        $result = $query->getResult();
        return $result;
    }

    public function getAllBookingsNurses($id, $type = 'nurse') {
        
        $sql = "SELECT doctor_bookings.*, customers.user_id, customers.first_name AS c_fname, 
        customers.last_name AS c_lname, customers.profile_photo, doctors.first_name AS d_fname, 
        doctors.last_name AS d_lname, doctors.photo, orders.billing_firstname, 
        orders.billing_lastname, orders.billing_email, orders.billing_address, 
        orders.billing_city, orders.billing_country_code
         FROM doctor_bookings 
        LEFT JOIN customers ON customers.id = doctor_bookings.customer_id 
        LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id
        LEFT JOIN orders ON orders.id = doctor_bookings.order_id WHERE doctor_bookings.doctor_id = ? ORDER BY doctor_bookings.booking_date DESC";
        $query = $this->db->query($sql, [$id]);
        $result = $query->getResult();
        return $result;
    }

    public function getDoctorBookings($id) {
        
        $sql = "SELECT doctor_bookings.*, doctors.user_id AS doc_user_id, customers.first_name AS c_fname, customers.last_name AS c_lname, customers.email AS c_email, customers.mobile AS c_mobile FROM doctor_bookings LEFT JOIN customers ON customers.id = doctor_bookings.customer_id LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id WHERE doctor_bookings.doctor_id = ? ORDER BY doctor_bookings.booking_date DESC";
        $query = $this->db->query($sql, [$id]);
        $result = $query->getResult();
        $rr = [];

        foreach($result as $row) {
            $sql = "SELECT * FROM orders WHERE id = ?";
            $query = $this->query($sql, [$row->order_id]);
            $r = $query->getRow();
            $row->order = $r;
            $rr[] = $row;
        }
        
        return $rr;
    }
    
    public function getAppointments($customerID) {
        $sql = "SELECT doctor_bookings.*, doctors.first_name AS d_fname, doctors.last_name AS d_lname FROM doctor_bookings LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id WHERE doctor_bookings.customer_id = ? AND doctor_bookings.status = 'pending' ORDER BY doctor_bookings.id DESC";
        $query = $this->db->query($sql, [$customerID]);
        $result = $query->getResult();
        return $result;
    }
    
    public function getDoctorAppointments($doctorID)
    {
        $sql = "SELECT doctor_bookings.*, doctors.channel_id, customers.first_name AS c_fname, customers.last_name AS c_lname FROM doctor_bookings LEFT JOIN customers ON customers.id = doctor_bookings.customer_id LEFT JOIN doctors ON doctors.id = doctor_bookings.doctor_id WHERE doctor_bookings.doctor_id = ? AND doctor_bookings.status = 'pending' ORDER BY doctor_bookings.booking_date DESC";
        $query = $this->db->query($sql, [$doctorID]);
        $result = $query->getResult();
        return $result;
    }
}