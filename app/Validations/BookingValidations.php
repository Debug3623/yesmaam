<?php
namespace App\Validations;

use App\Models\NurseBook;
use App\Models\DoctorBooking;

class BookingValidations 
{
	public function validDate($str, string $fields, array $data):bool
	{
		if($data['service_date'] >= date('Y-m-d')) {
			return true;
		}
		return false;
	}

	public function validTime($str, string $fields, array $data):bool
	{
		//$data['service_date'] == date('Y-m-d') && $data['service_time'] > date('h:i')
		$date = strtotime($data['service_date'] . ' ' . $data['service_time']);
		if($date > (time() + 1440)) {
			
			return true;
		}
		return false;
	}

	public function pre_booking($str, string $fields, array $data)
	{
		$date = strtotime($data['service_date'] . ' ' . $data['service_time']);
		if($date > (time() + 14400)) {
			return true;
		}
		return false;
	}

	public function validDocTime()
	{

	}
}