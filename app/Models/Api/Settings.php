<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class Settings extends Model
{
	protected $table = 'settings';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['store_name', 'nurse_hour_rate', 'nurse_week_rate', 'nurse_month_rate', 'doctor_hour_rate', 'doctor_week_rate', 'doctor_month_rate', 'currency_type', 'currency_icon', 'video_id', 'status'];
	protected $useTimestamps = false;
}