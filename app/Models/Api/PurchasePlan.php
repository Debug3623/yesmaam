<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class PurchasePlan extends Model
{
	protected $table = 'purchase_plans';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['plan_id', 'order_id','user_id', 'employee','physio_doctor','medical_camp','total_price','start_date','end_date','payment_status'];
	protected $useTimestamps = false;
}