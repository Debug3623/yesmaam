<?php
namespace App\Models\Api;

use CodeIgniter\Model;

Class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'customer_id', 'item_id', 'item_type', 'date_added', 'quantity', 'rate', 'status'
    ];
    protected $useTimestamps = false;

    public function getAllItems($customer_id)
    {
        $sql = "SELECT cart.*, customers.first_name AS c_fname, customers.last_name AS c_lname FROM cart LEFT JOIN customers ON customers.id = cart.customer_id WHERE cart.customer_id = ?";
        $query = $this->db->query($sql, [$customer_id]);
        $result = $query->getResult();
        return $result;
    }
}