<?php
namespace App\Models\Api; 

use CodeIgniter\Model;

class Employee extends Model
{
	protected $table = 'employees';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $allowedFields = ['company_code','user_id', 'fname', 'lname','gender','dob','visa_status','passport','address',
	'city','mobile','image','id_number','expiry_date','insurance','insurance_status','insurance_image','confirmed','id_image','insurance_id','country'];
	protected $useTimestamps = false;
}
