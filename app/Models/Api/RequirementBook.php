<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class RequirementBook extends Model
{
    protected $table = 'requirement_bookings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'requirement_id', 'bid_id', 'nurse_id', 'customer_id', 'booking_date_time', 'order_id', 'amount', 'status'
    ];

    protected $returnType = 'object';
    protected $useTimestamps = false;

    public function allAcceptedBids($customerID)
    {
        $sql = "SELECT requirement_bookings.*, requirements.category, requirements.start_date, requirements.end_date, requirements.time, requirements.details, requirements.budget, bids.price, bids.message, main_categories.name AS CATE_NAME, nurses.first_name AS n_fname, nurses.last_name AS n_lname FROM requirement_bookings LEFT JOIN requirements ON requirements.id = requirement_bookings.requirement_id LEFT JOIN bids ON bids.id = requirement_bookings.bid_id LEFT JOIN main_categories ON main_categories.id = requirements.category LEFT JOIN nurses ON nurses.id = requirement_bookings.nurse_id WHERE requirement_bookings.customer_id = ? ORDER BY requirement_bookings.booking_date_time DESC";

        $query = $this->db->query($sql, [$customerID]);
        $result = $query->getResult();
        return $result;
    }
}