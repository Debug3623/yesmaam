<?php

namespace App\Controllers\Admin;

use App\Models\Settings;
use App\Models\Api\Nurse;
use App\Models\Api\NurseBook;
use App\Models\DoctorBooking;

class BookingController extends \App\Controllers\BaseController
{

 
   
	public function bookedDoctors()
	{
		helper('form');
		$data['msg'] = session()->getFlashdata('msg');

		$doc = new DoctorBooking();
		$data['doctors'] = $doc->getAllDoctors();

		$setting = new Settings();
		$data['settings'] = $setting->first();

		return view('booking/allDoctors', $data);
	}

	public function bookedNurses()
	{
		helper('form');
		$data['msg'] = session()->getFlashdata('msg');

		$doc = new NurseBook();
		$data['doctors'] = $doc->getAllNurses();

		$setting = new Settings();
		$data['settings'] = $setting->first();

		return view('booking/allNurses', $data);
	}

	public function AddLink($id)
	{
		$db = new DoctorBooking();
		$booking = $db->where(['id' => DecryptId($id)])->first();

		if($booking) {
			$data['meeting_link'] = $this->request->getPost('link');
			$db->update($booking->id, $data);
		}
	}
  
  	public function singleNurseBooking($id)
	{
		helper(['form']);
		$booking = new NurseBook();
		$data['booking'] = $booking->getSingleNurseBooking(DecryptId($id));

		$nmodel = new Nurse();
		$data['nurses'] = $nmodel->where(['status' => 1, 'confirmed' => 1])->findAll();

		$setting = new \App\Models\Settings();
		$data['setting'] = $setting->first();

		$data['msg'] = session()->getFlashdata('msg');
		//dd($data['booking']);

		if($this->request->getMethod() == 'post') {
			$rules = [
				'billing_firstname' => [
					'label' => 'First Name',
					'rules' => 'trim|required'
				],
				'billing_lastname' => [
					'label' => 'Last Name',
					'rules' => 'trim|required'
				],
				'billing_email' => [
					'label' => 'Email Address',
					'rules' => 'trim|required'
				],
				'billing_city' => [
					'label' => 'City',
					'rules' => 'trim|required'
				],
				'billing_address' => [
					'label' => 'Address',
					'rules' => 'trim|required'
				],
				'customer_mobile' => [
					'label' => 'Mobile No.',
					'rules' => 'trim|required'
				],
				'nurse' => [
					'label' => 'Nurse',
					'rules' => 'trim|required'
				],
				
				'start_date' => [
					'label' => 'Service Start Date',
					'rules' => 'trim|required'
				],
				'service_end_date' => [
					'label' => 'Service End Date',
					'rules' => 'trim|required'
				],
				'service_time' => [
					'label' => 'Service Time',
					'rules' => 'trim|required'
				],
				'booked_for' => [
					'label' => 'Daily Booking Hours',
					'rules' => 'trim|required'
				],
				'special_instruction' => [
					'label' => 'Special Instructions',
					'rules' => 'trim'
				],
				'amount' => [
					'label' => 'Amount',
					'rules' => 'trim|required'
				],
				'payment_type' => [
					'label' => 'Payment Type',
					'rules' => 'trim|required'
				],
				'order_date' => [
					'label' => 'Order Date',
					'rules' => 'trim|required'
				],
			];
			
			if(!$this->validate($rules)) {
				$data['validator'] = $this->validator;
				return view('booking/single_nurse', $data);
			}
			
			
			//$nbdata['customer_id'] = $this->request->getPost('');
			$nbdata['nurse_id'] = $this->request->getPost('nurse');
			$nbdata['service_start_date'] = $this->request->getPost('start_date');
			$nbdata['service_end_date'] = $this->request->getPost('service_end_date');
			$nbdata['service_time'] = $this->request->getPost('service_time');
			$nbdata['booked_for'] = $this->request->getPost('booked_for');
			$nbdata['total_amount'] = $this->request->getPost('amount');
			// $nbdata['order_id'] = $this->request->getPost('');
			$nbdata['special_instruction'] = $this->request->getPost('special_instruction');
			$nbdata['booking_status'] = $this->request->getPost('booking_status');
			// dd($nbdata);
			$booking->update(DecryptId($id), $nbdata);
		
			$odata['amount'] = $this->request->getPost('amount');
			$odata['payment_type'] = $this->request->getPost('payment_type');
			//$odata['order_date'] = $this->request->getPost('order_date');
			$odata['item_id'] = $this->request->getPost('nurse');
			$odata['billing_firstname'] = $this->request->getPost('billing_firstname');
			$odata['billing_lastname'] = $this->request->getPost('billing_lastname');
			$odata['billing_email'] = $this->request->getPost('billing_email');
			$odata['billing_address'] = $this->request->getPost('billing_address');

			$order = new \App\Models\Api\Order();
			$o = $order->where(['id' => $data['booking']->order_id])->first();
			$order->update($o->id, $odata);

			session()->setFlashdata('msg', 'Booking Updated');
			return redirect()->to('admin/booking/nurse/single/' . $id);
		}
		else {
			return view('booking/single_nurse', $data);
		}
		
	}
	
	public function singleDoctorBooking($id)
	{
		helper(['form']);
		$booking = new DoctorBooking();
		$data['booking'] = $booking->getSingleDoctorBooking(DecryptId($id));

		$nmodel = new \App\Models\Doctor();
		$data['doctors'] = $nmodel->where(['status' => 1, 'confirmed' => 1])->findAll();

		$setting = new \App\Models\Settings();
		$data['setting'] = $setting->first();

		$data['msg'] = session()->getFlashdata('msg');
		//dd($data['booking']);

		if($this->request->getMethod() == 'post') {
			$rules = [
				'billing_firstname' => [
					'label' => 'First Name',
					'rules' => 'trim|required'
				],
				'billing_lastname' => [
					'label' => 'Last Name',
					'rules' => 'trim|required'
				],
				'billing_email' => [
					'label' => 'Email Address',
					'rules' => 'trim|required'
				],
				'billing_city' => [
					'label' => 'City',
					'rules' => 'trim|required'
				],
				'billing_address' => [
					'label' => 'Address',
					'rules' => 'trim|required'
				],
				'customer_mobile' => [
					'label' => 'Mobile No.',
					'rules' => 'trim|required'
				],
				'doctor' => [
					'label' => 'Doctor',
					'rules' => 'trim|required'
				],
				
				'start_date' => [
					'label' => 'Service Start Date',
					'rules' => 'trim|required'
				],
				'service_time' => [
					'label' => 'Service Time',
					'rules' => 'trim|required'
				],
				'amount' => [
					'label' => 'Amount',
					'rules' => 'trim|required'
				],
				'payment_type' => [
					'label' => 'Payment Type',
					'rules' => 'trim|required'
				],
				'order_date' => [
					'label' => 'Order Date',
					'rules' => 'trim|required'
				],
			];
			
			if(!$this->validate($rules)) {
				$data['validator'] = $this->validator;
				dd($data);
				return view('booking/single_doctor', $data);
			}
			
			$nbdata['doctor_id'] = $this->request->getPost('doctor');
			$nbdata['service_date'] = $this->request->getPost('start_date');
			$nbdata['service_time'] = $this->request->getPost('service_time');
			$nbdata['total_amount'] = $this->request->getPost('amount');
			$nbdata['status'] = $this->request->getPost('booking_status');
			//$nbdata['order_id'] = $this->request->getPost('');
			
			$booking->update(DecryptId($id), $nbdata);
		
			$odata['amount'] = $this->request->getPost('amount');
			$odata['payment_type'] = $this->request->getPost('payment_type');
			//$odata['order_date'] = $this->request->getPost('order_date');
			$odata['item_id'] = $this->request->getPost('doctor');
			$odata['billing_firstname'] = $this->request->getPost('billing_firstname');
			$odata['billing_lastname'] = $this->request->getPost('billing_lastname');
			$odata['billing_email'] = $this->request->getPost('billing_email');
			$odata['billing_address'] = $this->request->getPost('billing_address');

			$order = new \App\Models\Api\Order();
			$o = $order->where(['id' => $data['booking']->order_id])->first();
			$order->update($o->id, $odata);

			session()->setFlashdata('msg', 'Booking Updated');
			return redirect()->to('admin/booking/doctor/single/' . $id);
		}
		else {
			return view('booking/single_doctor', $data);
		}
		
	}

	public function cancelBooking($id)
	{
		$action = $this->request->getGet('action');
		$booking = new NurseBook();
		$book = $booking->where(['id' => DecryptId($id)])->first();

		$omodel = new \App\Models\Api\Order();
		$order = $omodel->where(['id' => $book->order_id])->first();

		if($action == 'cancel') {
			$bdata['booking_status'] = 'cancelled';
			$odata['order_status'] = 'cancelled';

			$booking->update($book->id, $bdata);
			$omodel->update($order->id, $odata);
		}
	}
	
	
	public function deleteBooking($id) {
		$model = new \App\Models\Api\DoctorBooking();
		$customer = $model->where(['id' => DecryptId($id)])->first();
		if($customer) {
         
		
			$model->delete($customer->id);
			
	    	session()->setFlashdata('success', 'Booking Deleted!');
			return redirect()->back();
		}
	}

	public function uploadPrescription($booking_id)
	{
		$file = $this->request->getFile('file');
		//dd($file);
		if(!$file) {
			session()->setFlashdata('success', 'Prescription Uploaded');
			return redirect()->back();
		}

		$loc = "documents/prescriptions/";
		$name = $file->getRandomName();

		if(!$file->move($loc, $name)) {
			session()->setFlashdata('success', 'Prescription Uploaded');
			return redirect()->back();
		}
		$bookM = new DoctorBooking();
		$bookM->update(DecryptId($booking_id), [
			'prescription' => $loc . $name
		]);
		session()->setFlashdata('success', 'Prescription Uploaded');
		return redirect()->back();
	}
	

}