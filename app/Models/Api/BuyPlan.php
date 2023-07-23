<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class BuyPlan extends Model
{
	protected $table = 'purchase_plans';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['plan_id', 'user_id', 'start_date'];
	protected $useTimestamps = false;
}