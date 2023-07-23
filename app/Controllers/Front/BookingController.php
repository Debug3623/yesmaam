<?php
namespace App\Controllers\Front;

use App\Models\Order;
use App\Models\Nurse;
use App\Models\Doctor;
use App\Models\Customer;
use App\Models\Settings;
use App\Models\NurseBook;
use App\Models\DoctorBooking;

class BookingController extends \App\Controllers\BaseController
{
	public function bookNurse($id)
	{
		$nurse = new Nurse();
		$data['nurse'] = $nurse->where(['id' => DecryptId($id)])->first();

		$setting = new Settings();
		$data['setting'] = $setting->first();

		$data['msg'] = session()->getFlashdata('msg');
		helper('form');
		$data['errmsg'] = '';

		//dd(session()->get());


		if($this->request->getMethod() == 'post') {
			//dd($_POST);

			$nurse_id = DecryptId($id);
			$customer = new Customer();
			$customer = $customer->where(['email' => session()->get('customer')['email']])->first();

			$customer_id = $customer->id;

			$rules = [
				'start_date' => [
					'label' => 'Service Start Date',
					'rules' => 'trim|required'
				],
				'end_date' => [
					'label' => 'Service End Date',
					'rules' => 'trim|required'
				],
				'service_time' => [
					'label' => 'Service Booking time',
					'rules' => 'trim|required'
				],
				'booked_for' => [
					'label' => 'Service Booking For',
					'rules' => 'trim|required'
				]
			];

			if($this->validate($rules)) {
				//dd("Die");
				$bdata['customer_id'] = $customer_id;
				$bdata['nurse_id'] = $nurse_id;
				

				$book = new NurseBook();
				//$bookings = $book->where(['nurse_id' => $nurse_id])->findAll();

				
				$bdata['service_start_date'] = $this->request->getPost('start_date');
				$bdata['service_end_date'] = $this->request->getPost('end_date');
				$bdata['booked_for'] = $this->request->getPost('booked_for');
				$bdata['service_time'] = $this->request->getPost('service_time');

				$now = strtotime($bdata['service_end_date']); // or your date as well
				$your_date = strtotime($bdata['service_start_date']);
				$datediff = $now - $your_date;
				$days = 1 + round($datediff / (60 * 60 * 24));
				//dd($bdata['booked_for']);
				$bdata['total_amount'] = $data['setting']->nurse_hour_rate * $days * $bdata['booked_for'];
				//dd($bdata);

				if($this->isNurseAvailable($nurse_id, $bdata['service_start_date'], $bdata['service_end_date'], $bdata['service_time'])) {
					
					$bdata['status'] = 0;

					session()->set('booking', $bdata);

					return redirect('order/summary');
				}
				else {
					$data['errmsg'] = "Nurse is not available for the given Date and Time";
					return view('booking/nurse_book', $data);	
				}

				
			}
			else {
				$data['validator'] = $this->validator;
				//dd($this->validator->getErrors());
				return view('booking/nurse_book', $data);
			}
		}
		else {
			return view('booking/nurse_book', $data);
		}
	}

	public function isNurseAvailable($id, $start_date, $end_date, $time)
	{
		$nurseB = new NurseBook();
		$bookings = $nurseB->where([
			'nurse_id' => $id
		])->findAll();

		if(!$bookings) {
			return true;
		}

		//$start_date = strtotime($start_date); 
		//$end_date = strtotime($end_date); 
		//dd($end_date);
		foreach($bookings as $b) {
			if($start_date >= ($b->service_start_date) && $start_date <= ($b->service_end_date)) {
				return false;
			}
			else if($end_date >= ($b->service_start_date) && $end_date <= ($b->service_end_date)) {
				return false;
			}
			else {
				return true;
			}
		}
	}


	public function bookDoctor($id)
	{
		$doctor = new Doctor();
		$data['doctor'] = $doctor->where(['id' => DecryptId($id)])->first();

		$data['msg'] = session()->getFlashdata('msg');
		helper('form');

		//dd(session()->get());


		if($this->request->getMethod() == 'post') {
			$doctor_id = DecryptId($id);
			//dd($id);
			$customer = new Customer();
			$customer = $customer->where(['email' => session()->get('customer')['email']])->first();

			$customer_id = $customer->id;

			$rules = [
				'service_date' => [
					'label' => 'Service Date',
					'rules' => 'trim|required|validDate[service_date]',
                  	'errors' => [
                    	'validDate' => 'Please select a date in the future'
                    ],
				],
				'service_time' => [
					'label' => 'Service Time',
					'rules' => 'trim|required|validDocTime[service_time,service_date]',
                  	'errors' => [
                    	'validTime' => 'Please select a datetime in the future'
                    ],
				]
			];

			$bdata['customer_id'] = $customer_id;
			$bdata['doctor_id'] = $doctor_id;
			$bdata['service_date'] = $this->request->getPost('service_date');
			$bdata['service_time'] = $this->request->getPost('service_time');

			$bdata['booking_date'] = date('Y-m-d H:i:s');
			$bdata['status'] = 1;

			if($this->validate($rules)) {
				if($this->isDoctorAvailable($doctor_id, $bdata['service_date'], $bdata['service_time'])) {
					
					
					//dd($bdata);
					//$book = new DoctorBooking();
					//$book->insert($bdata);
					session()->set('dbooking', $bdata);

					return redirect('order/doctor/summary');
					
				}
				else {
					$data['errmsg'] = "Nurse is not available for the given Date and Time";
					return view('booking/nurse_book', $data);	
				}
				
			}
			else {
				$data['validator'] = $this->validator;
				return view('booking/doctor_book', $data);
			}
		}
		else {
			return view('booking/doctor_book', $data);
		}
	}

	public function isDoctorAvailable($id, $start_date, $time)
	{
      	//dd(strtotime($time));
		$time = date('H:i', strtotime($time) + 14400);
		$doctorB = new DoctorBooking();
		$bookings = $doctorB->where([
			'doctor_id' => $id,
			'service_date' => $start_date
		])->findAll();

		if(!$bookings) {
			return true;
		}

		foreach($bookings as $b) {
			if($b < $time) {
				return false;
			}
			else {
				return true;
			}
		}
	}
  
  	
}