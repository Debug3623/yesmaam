<?php
namespace App\Models; 

use CodeIgniter\Model;

class Order extends Model
{
	protected $table = 'orders';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = [
      'customer_id', 'amount', 'payment_type', 'order_date', 'order_id', 'order_for', 'item_id', 
      'payment_id', 'billing_firstname', 'billing_lastname', 'billing_email', 'billing_address', 
      'billing_city', 'billing_country_code', 'payment_status'
    ];
	protected $useTimestamps = true;
}