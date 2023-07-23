<?php
namespace App\Models\Api;

use CodeIgniter\Model;

Class ServiceBook extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'service_bookings';
    protected $returnType = 'object';
    protected $allowedFields = [
        'service_id', 'customer_id', 'booking_date', 'order_id', 'status'
    ];
    protected $useTimestamps = true;

    public function getServiceBookings()
    {
        $sql = "SELECT service_bookings.*, customers.first_name, customers.last_name FROM service_bookings LEFT JOIN customers ON customers.id = service_bookings.customer_id WHERE service_bookings.status = 'completed'";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }

    public function getSingleServiceBooking($id)
	{
		$sql = "SELECT service_bookings.*, customers.mobile AS c_mobile, orders.order_date, orders.payment_type, orders.billing_firstname, orders.billing_lastname, orders.billing_email, orders.billing_address, orders.billing_city, orders.payment_status, orders.amount FROM service_bookings LEFT JOIN orders ON orders.id = service_bookings.order_id LEFT JOIN customers ON customers.id = service_bookings.customer_id WHERE service_bookings.id = ?";
		$query = $this->db->query($sql, [$id]);
		$result = $query->getRow();
		
		return $result;
	}
}