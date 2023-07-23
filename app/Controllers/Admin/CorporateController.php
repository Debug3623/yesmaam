<?php
namespace App\Controllers\Admin;
use Exception;

use App\Models\User;
use App\Models\Api\Document;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Api\Referral;
use App\Models\Api\Employee;


use App\Models\Admin\CoporateUser;

class CorporateController extends \App\Controllers\BaseController
{
	public function index()
	{
		$doc = new CoporateUser();
		$data['corporate'] = $doc->getCorporateUsers();
		
	//	var_dump(	$data['corporate']);die();
		return view('corporates/all', $data);
	}
	
		public function corporateLicense($user_id)
	{
		$corporate = new Document();
		$data['documents'] = $corporate->getDocuments($user_id);
		
		return view('corporates/license', $data);
	}
	
		public function corporateEmployees()
	{
		$corporate = new CoporateUser();
		$data['corporate'] = $corporate->getCorporateEmployee();
	

		return view('corporates/employee', $data);
	}
	
			public function billing()
	{
		$corporate = new CoporateUser();
		$data['billing'] = $corporate->getEmployeeBilling();
		//var_dump($data['corporate']);die();
		return view('corporates/billing', $data);
	}
	
		
	public function getCustomer($id)
	{
		$corporate = new CoporateUser();
		$data['customer'] = $corporate->getCustomersCorporate(DecryptId($id));
		
		return view('corporates/customer', $data);
	}
	
	public function singleCorporateBilling($id)
	{
		helper(['form']);
		$booking = new CoporateUser();
		$data['booking'] = $booking->getSinglePlanBooking(DecryptId($id));
// var_dump(	$data['booking']);die();
	

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
			//return redirect()->to('admin/booking/doctor/single/' . $id);
		}
		else {
			return view('corporates/company_billing', $data);
		}
		
	}
	
	
	
	
  
  public function confirmDoctor($id)
	{
		$model = new Doctor();
		$doc = $model->where(['id' => DecryptId($id)])->first();
		if($doc) {
			$data['confirmed'] = 1;
			$model->update($doc->id, $data);
		}
	}


	public function addCorporate()
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

// 		$cate = new Category();
// 		$data['categories'] = $cate->where(['status' => 1, 'cate_for' => 'doctor'])->findAll();

		if($this->request->getMethod() == 'post') {
			

			$rules = [
				'first_name' => [
					'label' => 'First Name',
					'rules' => 'trim|required',
				],
	
				'last_name' => [
					'label' => 'Last Name',
					'rules' => 'trim',
				],
				'company_email' => [
					'label' => 'Email Address',
					'rules' => 'trim|required',
				],
				'mobile' => [
					'label' => 'Mobile no.',
					'rules' => 'trim|required',
				],
			
				'password' => [
					'label' => 'Password',
					'rules' => 'trim|required',
				],
		
			];

			if($this->request->getPost('password') != '') {
				$rules['password'] = [
					'label' => 'Password',
					'rules' => 'trim|required'
				];
				$rules['password2'] = [
					'label' => 'Re-Type Password',
					'rules' => 'trim|required|matches[password]',
					'errors' => [
						'matches' => 'Password Mismatch'
					]
				];
			}

			$photo = $this->request->getFile('image');
          	//dd($photo);
			if($photo && $photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]|is_image[photo]'
				];
			}
			
// 			$doc = $this->request->getFile('medical_licence');
//           	//dd($doc);
// 			if($doc && $doc->isValid() && !$doc->hasMoved()) {
// 				$rules['medical_licence'] = [
// 					'label' => 'Medical Licence',
// 					'rules' => 'uploaded[photo]'
// 				];
// 			}

			//if($this->validate($rules)) {
				$umodel = new \App\Models\Api\User();
    			$udata['name'] = $this->request->getPost('first_name');
    			$udata['email'] = $this->request->getPost('company_email');
    			$udata['username'] = $this->request->getPost('last_name');
    			$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
                $udata['user_type'] = 'corporate';
                $udata['phone'] =$this->request->getPost('mobile');
    			$udata['phone_verified'] = 1;
    			$udata['email_verified'] = 1;

				if($this->request->getPost('password') != '') {
					$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
				}
				
				$udata['user_type'] = 'corporate';
				$udata['status'] = 1;
				
				
                $user = new \App\Models\Api\User();
                $u = $user->where(['phone' =>  $udata['phone']])->first();
                
                $uemail = $user->where(['email' =>  $udata['email']])->first();
    
                
                $corporate = $user->where(['user_type' => 'corporate'])->first();
                
                
                if($u && $corporate ) {
            	session()->setFlashdata('msg', 'Phone is already exists');

                }
                
                if($uemail && $corporate)
                {
            	session()->setFlashdata('msg', 'Email is already exists');
    
                }
				
				$user_id = $umodel->insert($udata);
				
        		//Referral Code
        		
        	     $referral_code =str_replace(' ','',strtolower(trim($this->request->getPost('company_name'))).rand(1000,9999)) ;
        	     
        	       $referrals = [
                    'user_id' => $user_id, 
                    'referral_code' => $referral_code, 
                   ];
                   
                 $referral = new Referral();
			  	 $ref_id=$referral->insert($referrals);
			  	 
        		//End Referral Code
        		
        		
        		$cdata['first_name'] = $this->request->getPost('first_name');
        		$cdata['last_name'] = $this->request->getPost('last_name');
            	$cdata['company_name'] = $this->request->getPost('company_name');
				$cdata['company_address'] = $this->request->getPost('company_address');
				$cdata['company_email'] = $this->request->getPost('company_email');
				$cdata['city'] = $this->request->getPost('city');
				$cdata['about'] = $this->request->getPost('about');
				$cdata['mobile'] = $this->request->getPost('mobile');
				$cdata['user_id'] = $user_id;
				$cdata['status'] = 1;
				$cdata['available'] = 'No';
				$cdata['confirmed'] = 0;
			    $cdata['phone_verified	'] = 1;
				
				

				//dd($cdata);

				if($photo && $photo->isValid() && !$photo->hasMoved()) {
					$name = $photo->getRandomName();
					$loc = 'images/corporates';

					$photo->move($loc, $name);
					$cdata['image'] = 'images/corporates/' . $name;
				}

		

				$model = new CoporateUser();
				$id=$model->insert($cdata);
				
			    $filesUploaded = 0;
 
        if($this->request->getFileMultiple('filename'))
        {
            $files = $this->request->getFileMultiple('filename');
 
            foreach ($files as $file) {
 
                if ($file->isValid() && ! $file->hasMoved())
                {
                    $newName = $file->getRandomName();
                    $file->move('documents/corporates', $newName);
                    $data = [
                        'filename' => $newName,
                        'filepath' => 'documents/corporates' . $newName,
                        'type' => $file->getClientExtension(),
                        'user_id'=>$user_id
                    ];
                    $fileUploadModel = new Document();
                    $fileUploadModel->save($data);
                    $filesUploaded++;
                }
                 
            }
 
        }

				session()->setFlashdata('msg', 'Corporate Added');
				return redirect()->to('admin/corporate/add');
// 			}
// 			else {
// 				$data['validator'] = $this->validator;
// 				return view("corporates/add", $data);
// 			}
		}
		else {
			return view("corporates/add", $data);
		}
	}

	public function updateCorporate($id)
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

		$cate = new Category();
		$data['categories'] = $cate->where(['status' => 1, 'cate_for' => 'doctor'])->findAll();

		$doc = new CoporateUser();
	//	$data['corporate'] = $doc->where(['id' => DecryptId($id)])->first();
				$data['corporate'] = $doc->getCorporate(DecryptId($id));
				
			//	var_dump(	$data['corporate']); die();
// 		 $referral = new Referral();
// 		 $data['corporate']=$referral->where(['id' => DecryptId($id)])->first();

		$umodel = new \App\Models\Api\User();
		$user = $umodel->where(['id' => $data['corporate']->user_id])->first();
		$data['user'] = $user;

		if($this->request->getMethod() == 'post') {
			$rules = [
				'first_name' => [
					'label' => 'First Name',
					'rules' => 'trim|required',
				],
		
				'last_name' => [
					'label' => 'Last Name',
					'rules' => 'trim',
				],
				'company_name' => [
					'label' => 'Company Name',
					'rules' => 'trim',
				],
				
				'company_email' => [
					'label' => 'Email Address',
					'rules' => 'trim|required',
				],
				'mobile' => [
					'label' => 'Mobile no.',
					'rules' => 'trim|required',
				],
				'company_address' => [
					'label' => 'Company Address',
					'rules' => 'trim|required',
				],
				'city' => [
					'label' => 'City',
					'rules' => 'trim|required',
				],
				'about' => [
					'label' => 'About',
					'rules' => 'trim|required',
				],
				
			

			];

			if($this->request->getPost('password') != '') {
				$rules['password'] = [
					'label' => 'Password',
					'rules' => 'trim|required'
				];
				$rules['password2'] = [
					'label' => 'Re-Type Password',
					'rules' => 'trim|required|matches[password]',
					'errors' => [
						'matches' => 'Password Mismatch'
					]
				];
			}


			//dd($rules);
			if($this->validate($rules)) {
				
				
				//dd($user);
				$udata['name'] = $this->request->getPost('first_name');
				$udata['email'] = $this->request->getPost('email');
				$udata['username'] = $this->request->getPost('username');
				$udata['phone'] = $this->request->getPost('mobile');
			

				if($this->request->getPost('password') != '') {
					$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
				}
				
				$udata['user_type'] = 'corporate';
				
				$udata['status'] = 1;

				if($user == null && $data['corporate']->user_id == 0) {
					$user_id = $umodel->insert($udata);
				}
				else {
					$umodel->update($user->id, $udata);
					$user_id = $user->id;
				}
				
					$image	= $this->request->getFile('image');

        			//dd($_FILES);
        			if($image && $image->isValid() && !$image->hasMoved()) {
        				$rules['image'] = [
        					'label' => 'Profile Image',
        					'rules' => 'uploaded[image]|ext_in[photo,png,jpg,gif,jpeg]'
        				];
        			}

				$cdata['first_name'] = $this->request->getPost('first_name');
				$cdata['last_name'] = $this->request->getPost('last_name');
				$cdata['company_name'] = $this->request->getPost('company_name');
				$cdata['mobile'] = $this->request->getPost('mobile');
				$cdata['company_address'] = $this->request->getPost('company_address');
				$cdata['city'] = $this->request->getPost('city');
				$cdata['about'] = $this->request->getPost('about');
				$cdata['user_id'] = $user_id;
				$cdata['status'] = 1;
				
					if($image && $image->isValid() && !$image->hasMoved())  {
					$loc = '/images/corporate/';
					$name = $image->getRandomName();
					if($image->move($loc, $name)) {
						if(is_file($data['corporate']->image)) {
							if($data['corporate']->image != 'images/male_icon.png' && $data['corporate']->image != 'images/female_icon.png') {
								unlink($data['corporate']->image);
							}
							
						}	
						$cdata['image'] = $loc . $name;
					}
				}
				
				
				
				//dd($cdata);
				$model = new CoporateUser();
				$model->update(DecryptId($id), $cdata);

				session()->setFlashdata('msg', 'Corporate Updated');
				return redirect()->to('admin/corporate/update/' . $id);
			}
			else {
				$data['validator'] = $this->validator;
				//dd($this->validator->getErrors());
				return view("corporates/update", $data);
			}
		}
		else {
			return view("corporates/update", $data);
		}
	}



	public function updateEmployee($id)
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');


		$employee = new Employee();
		$data['employee'] = $employee->where(['id' => DecryptId($id)])->first();

		$umodel = new \App\Models\Api\User();
		$user = $umodel->where(['id' => $data['employee']->user_id])->first();
		$data['user'] = $user;

		if($this->request->getMethod() == 'post') {
			$rules = [
				'fname' => [
					'label' => 'First Name',
					'rules' => 'trim|required',
				],
		
				'lname' => [
					'label' => 'Last Name',
					'rules' => 'trim',
				],
				'email' => [
					'label' => 'Email',
					'rules' => 'trim',
				],
				
				'address' => [
					'label' => 'Address',
					'rules' => 'trim|required',
				],
				'mobile' => [
					'label' => 'Mobile no.',
					'rules' => 'trim|required',
				],
				'company_address' => [
					'label' => 'Company Address',
					'rules' => 'trim|required',
				],
	

			];


			//dd($rules);
// 			if($this->validate($rules)) {
				
				
				//dd($user);
				$udata['name'] = $this->request->getPost('fname');
				$udata['email'] = $this->request->getPost('email');
				$udata['lname'] = $this->request->getPost('username');
				$udata['phone'] = $this->request->getPost('mobile');
			

					$umodel->update($user->id, $udata);
					$user_id = $user->id;
	
				
					$image	= $this->request->getFile('image');
					$id_image	= $this->request->getFile('id_image');


        			//dd($_FILES);
        			if($image && $image->isValid() && !$image->hasMoved()) {
        				$rules['image'] = [
        					'label' => 'Profile Image',
        					'rules' => 'uploaded[image]|ext_in[photo,png,jpg,gif,jpeg]'
        				];
        			}
        			
        				if($id_image && $id_image->isValid() && !$id_image->hasMoved()) {
        				$rules['id_image'] = [
        					'label' => 'Profile Image',
        					'rules' => 'uploaded[id_image]|ext_in[photo,png,jpg,gif,jpeg]'
        				];
        			}

				$cdata['fname'] = $this->request->getPost('fname');
				$cdata['lname'] = $this->request->getPost('lname');
				$cdata['mobile'] = $this->request->getPost('mobile');
				$cdata['address'] = $this->request->getPost('address');
				$cdata['city'] = $this->request->getPost('city');
				$cdata['visa_status'] = $this->request->getPost('visa_status');
				$cdata['id_number'] = $this->request->getPost('id_number');
				$cdata['expiry_date'] = $this->request->getPost('expiry_date');
				$cdata['insurance_id'] = $this->request->getPost('insurance_id');
				$cdata['passport'] = $this->request->getPost('passport');
            	$cdata['insurance_status'] = $this->request->getPost('insurance_status');
				$cdata['country'] = $this->request->getPost('country');

				
					if($image && $image->isValid() && !$image->hasMoved())  {
					$loc = './images/employee/';
					$name = $image->getRandomName();
					if($image->move($loc, $name)) {
						if(is_file($data['employee']->image)) {
							if($data['employee']->image != 'images/male_icon.png' && $data['employee']->image != 'images/female_icon.png') {
								unlink($data['employee']->image);
							}
							
						}	
						$cdata['image'] = $loc . $name;
					}
				}
				
				
					if($id_image && $id_image->isValid() && !$id_image->hasMoved())  {
					$loc = './images/emirateId/';
					$name = $id_image->getRandomName();
					if($id_image->move($loc, $name)) {
						if(is_file($data['employee']->id_image)) {
							if($data['employee']->id_image != 'images/male_icon.png' && $data['employee']->id_image != 'images/female_icon.png') {
								unlink($data['employee']->id_image);
							}
							
						}	
						$cdata['id_image'] = $loc . $name;
					}
				}
				
		
				$model = new Employee();
				$model->update(DecryptId($id), $cdata);

				session()->setFlashdata('msg', 'Employee Updated');
				return redirect()->to('admin/corporate/employee/update/' . $id);

		}
		else {
			return view("corporates/employee_update", $data);
		}
	}


	public function deleteCorporate($id) {
		$model = new CoporateUser();
		$corporate = $model->where(['id' => DecryptId($id)])->first();
		if($corporate) {
			$userM = new \App\Models\Api\User();
			$user = $userM->where(['id' => $corporate->user_id])->first();
			$corDocument = new \App\Models\Api\Document();
			$cordoc = $corDocument->where(['user_id' => $corporate->user_id])->first();
			if($user) {
				$userM->delete($user->id);
			}
			if($cordoc) {
				$userM->delete($cordoc->id);
			}
			$model->delete($corporate->id);
		}
	}

	public function changeAvailability($corporate_id, $status = 0)
	{
		$corporate = new CoporateUser();
		$cor = $corporate->where(['id' => DecryptId($corporate_id)])->first();
		if($cor) {
			$corporate->update($cor->id, ['confirmed' => $status]);
		}
	}

	public function changeDoctorFor($doctorId)
	{
		$doctorM = new \App\Models\Admin\Doctor();
		$doc = $doctorM->where(['id' => DecryptId($doctorId)])->first();
		if($doc) {
			$doctorM->update($doc->id, [
				'doctor_from' => $this->request->getPost('doctor_from')
			]);
			return "true";
		}
	}
}