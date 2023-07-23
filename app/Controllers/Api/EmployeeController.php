<?php

namespace App\Controllers\Api;

use Exception;
use App\Models;
use App\Models\Api\Nurse;
use App\Models\Api\User;
use App\Libraries\Email;
use App\Models\Api\Customer;
use App\Models\Api\Referral;
use App\Models\Api\Settings;
use App\Models\Api\PurchasePlan;
use App\Models\Api\CoporateUser;
use App\Models\Api\Employee;
use App\Models\Api\Document;
use App\Models\Api\EmailVerification;
use CodeIgniter\RESTful\ResourceController;

class EmployeeController extends ResourceController
{
    protected $modelName = 'App\Models\Api\Employee';
    protected $format = 'json';
    public $tab_users = 'employees';


    public function employee_register()
    {
        try {
            $json = $this->request->getJSON();
            
            
            $udata['name'] = $this->request->getPost('fname');
			$udata['username'] = $this->request->getPost('lname');
			$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
            $udata['user_type'] = 'employee';
            $udata['phone'] =$this->request->getPost('mobile');
            $code= $this->request->getPost('company_code');
        
            $user = new \App\Models\Api\User();
            $u = $user->where(['phone' =>  $udata['phone']])->first();
            
            $corporate = $user->where(['user_type' => 'employee'])->first();
              	//Referral Code
        		$referral = new Referral();
		    	$referral_codes = $referral->where(['referral_code' => 	$code])->first();
		    
                 if(!$referral_codes) {
                throw new Exception("Company code is not valid!");
                }
		    
            
            if($u && $corporate ) {
                throw new Exception("User is already exists");
            }
            
          
            
            
      	        $docs = new User();
				$user_id=$docs->insert($udata);
			
        		$photo = $this->request->getFile('photo');
              	//dd($photo);
    			if($photo && $photo->isValid() && !$photo->hasMoved()) {
    				$rules['photo'] = [
    					'label' => 'Profile Photo',
    					'rules' => 'uploaded[photo]|is_image[photo]'
    				];
    			}
    			
    			$insurance_image = $this->request->getFile('insurance_image');
    			$id_image = $this->request->getFile('id_image');
    			$image = $this->request->getFile('image');

              	//dd($doc);
    			if($insurance_image && $insurance_image->isValid() && !$insurance_image->hasMoved()) {
    				$rules['insurance_image'] = [
    					'label' => 'Insurance',
    					'rules' => 'uploaded[photo]'
    				];
    			}
    				if($id_image && $id_image->isValid() && !$id_image->hasMoved()) {
    				$rules['id_image'] = [
    					'label' => 'Emirate Id',
    					'rules' => 'uploaded[photo]'
    				];
    			}
    			
    				if($image && $image->isValid() && !$image->hasMoved()) {
    				$rules['image'] = [
    					'label' => 'image',
    					'rules' => 'uploaded[photo]'
    				];
    			}
    			

            
				$ddata['lname'] = $this->request->getPost('lname');
				$ddata['fname'] = $this->request->getPost('fname');
				$ddata['mobile'] = $this->request->getPost('mobile');
				$ddata['user_id'] = $user_id;
				$ddata['gender'] = $this->request->getPost('gender');
				$ddata['dob'] = $this->request->getPost('dob');
				$ddata['visa_status'] = $this->request->getPost('visa_status');
			    $ddata['country'] = $this->request->getPost('country');
		    	$ddata['passport'] = $this->request->getPost('passport');
				$ddata['address'] = $this->request->getPost('address');
				$ddata['city'] = $this->request->getPost('city');
			    $ddata['id_number'] = $this->request->getPost('id_number');
				$ddata['expiry_date'] = $this->request->getPost('expiry_date');
			
			    $ddata['insurance'] = $this->request->getPost('insurance');
			    $ddata['insurance_id'] = $this->request->getPost('insurance_id');
			    
			    if($ddata['insurance'] =="Yes")
			    {
			        $ddata['insurance_status'] ="pending";
			        
			    }
			    elseif($ddata['insurance'] =="No")
			    {
			        $ddata['insurance_status'] ="not available";

			    }

	        
               $company_code=$referral_codes->user_id;
               
       
               	$ddata['company_code'] = $company_code;
               	
               	                
					if($insurance_image && $insurance_image->isValid() && !$insurance_image->hasMoved()) {
					$name = $insurance_image->getRandomName();
					$loc = 'images/insurance';

					$insurance_image->move($loc, $name);
					$ddata['insurance_image'] = 'images/insurance/' . $name;
				}
				
					if($id_image && $id_image->isValid() && !$id_image->hasMoved()) {
					$name = $id_image->getRandomName();
					$loc = 'images/emirateId';

					$id_image->move($loc, $name);
					$ddata['id_image'] = 'images/emirateId/' . $name;
				}
				
					if($image && $image->isValid() && !$image->hasMoved()) {
					$name = $image->getRandomName();
					$loc = 'images/employee';

					$image->move($loc, $name);
					$ddata['image'] = 'images/employee/' . $name;
				}
        

		
				$doc = new Employee();
				$id=$doc->insert($ddata);
				
				$details = $doc->where(['id' => $id])->first();


                $otp = new \App\Libraries\Sms();
                $data = [
                "name" => $this->request->getPost('fname'),
                "code" => rand(1000, 9999),
                "phone" => $this->request->getPost('mobile')
            ];

            $response = $otp->sendOTP($data);
            
           // var_dump($response);die();
            $smsdata = [
                'user_id' => $user_id, 
                'mobile' => $this->request->getPost('mobile'), 
                'code' => $data['code'], 
                'date_time' => date('Y-m-d H:i:s'), 
                'status' => 1
            ];

            $vmodel = new \App\Models\Api\MobileVerification();
            $verification = $vmodel->where(['user_id' => $user_id])->first();
            if($verification) {
                $vmodel->update($verification->id, $smsdata);
            }
            else {
                $vmodel->insert($smsdata);
            }
            
            
            $cdata['user_id'] = $user_id;
            
            $url = 'https://yesmaam.ae/test_yesmaam_api/public/documents/corporates/';
            $doco= new Document();
            $datass= $doco->select("id,user_id,CONCAT('$url','',filename) as filename")->where(['user_id' => $user_id])->findAll();
          

            $settingM = new \App\Models\Api\Settings();
            $setting = $settingM->first();
            return $this->respond([
                'status' => 200,
                'message' => 'Employee Registerd Successfully',
                   'id' => $details->id,
                   'code' => $data['code'],
                   'company_code' => $details->company_code,
                   'fname' => $details->fname,
                   'lname' => $details->lname,
                   'gender'=>$details->gender,
                   'mobile' => $details->mobile,
                   'dob' => $details->dob,
                   'image'=>$details->image,
                   'user_id' => $details->user_id,
                   'visa_status' => $details->visa_status,
                   'country' => $details->country,
                   'passport' =>$details->passport,
                   'address' =>$details->address,
                   'city' =>$details->city,
                   'id_number' =>$details->id_number,
                   'id_image' =>$details->id_image,
                   'expiry_date' =>$details->expiry_date,
                   'insurance' =>$details->insurance,
                   'insurance_status' =>$details->insurance_status,
                   'insurance_id' =>$details->insurance_id,
                    'insurance_image' =>$details->insurance_image,
                   'confirmed' =>$details->confirmed,
  

            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 401, 
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }
    
    
      
        public function getEmployeeProfile()

    {


        try {
            

            $user_id =$this->request->getPost('user_id');
             
            $user = new \App\Models\Api\Employee();
            $uemail = $user->where(['user_id' =>  $user_id])->first();
            

            if(!$uemail) {

                throw new Exception("Employee not Found");

            }
        
            
            return $this->respond([
                'status' => 200,
                'message' => 'Get Employee Profile',
                'data' => $uemail,
         
                   
            ]);


        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }
    
    
      public function getEmployeeStatistics()

    {


        try {
            

            $user_id =$this->request->getPost('user_id');
             
            $user = new \App\Models\Api\Employee();
            $uemail = $user->where(['company_code' =>  $user_id])->first();
            

            if(!$uemail) {
                
                $datas['totalEmployees']=0;
                 $datas['pending']=0;
              $datas['approved']=0;
                  return $this->respond([
                'status' => 200,
                'message' => 'Corporate Employees Statistics',
                'data' => $datas,
         
                   
            ]);

            }
            
            $uemail = $user->where(['company_code' =>  $user_id])->first();
            $data['totalEmployees'] = $user->where(['company_code' =>  $user_id,])->countAllResults();
            $data['pending'] = $user->where(['company_code' =>  $user_id,'confirmed' => '0'])->countAllResults();
            $data['approved'] = $user->where(['company_code' =>  $user_id,'confirmed' => '1'])->countAllResults();

            
            return $this->respond([
                'status' => 200,
                'message' => 'Corporate Employees Statistics',
                'data' => $data,
         
                   
            ]);


        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }
    
    
       public function updateReferral() {

        try {

            $json = $this->request->getJSON();

            $user_id = $this->request->getPost('user_id');

            $referral = new Referral();
			$referral_code = $referral->where(['user_id' => $user_id])->first();
			  	 
		    if(!$referral_code) {

                throw new Exception("User not Found");

            }

            $referral_codes['referral_code'] = $this->request->getPost('referral_code');
            
         	$referral->update($referral_code->id,$referral_codes);

            return $this->respond(['status' => '200', 'message' => 'Referral Code Updated']);

            

        }

        catch(Exception $e) {

            return $this->fail(['message' => $e->getMessage()]);

        }

    }
    
    
    public function companyVerification() {
        
            $referral_code = $this->request->getPost('referral_code');

            $referral = new Referral();
			$referral_codes = $referral->where(['referral_code' => $referral_code])->first();
			  	 
		    if(!$referral_codes) {

            return $this->respond(['status' => 401, 'message' => 'Corporation is not Exist']);

            }
            else
            {
            
             $user = new \App\Models\Api\CoporateUser();
             $data= $user->select('company_name')->where(['user_id' => $referral_codes->user_id])->first();
             
             $datas = $data->company_name;
             
            return $this->respond(['status' => 200, 'message' => 'Company Code','company_name'=>$datas]);
   }
        
        
    }
    
        /**
     * This Function deletes all records of the User
     * @return string
    */
    public function deleteEmployeeAccount()
    {
        try {
            $json = $this->request->getJSON();
            // $userId = $json->user_id;
            
            $userId = $this->request->getPost('user_id');

              $employee = new \App\Models\Api\Employee();

                   $model = new \App\Models\Api\User();
                   $person = $model->where(['id' => $userId])->first();
                
                    $users = $model->where(['id' =>$userId])->findAll();
                    foreach($users as $ds) {
                        $model->delete($ds->id);
                    }
       

                if(!$person) {
                    throw new Exception("Employee not found");
                }

                $nurse = $employee->where(['user_id' => $person->id])->findAll();
                foreach($nurse as $d) {
                    $employee->delete($d->id);
                }
   
            return $this->respond(['status' => 200, 'message' => 'Your account has been deleted']);
            
          

        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 401,
                'message' => $e->getMessage()
            ]);
        }
    }

   public function updateProfile() {

        try {

            $json = $this->request->getJSON();

            $user_id = $this->request->getPost('user_id');

            $models = new \App\Models\Api\CoporateUser();
            $corporate = $models->where(['user_id' => $user_id])->first();

            if(!$corporate) {

                throw new Exception("corporate not Found");

            }


            $user_corporate = new CoporateUser();

            $u = $user_corporate->where(['user_id' => $user_id])->first();

            if(!$u) {

                throw new Exception("Invalid User Id");

            }

            $user = new User();
            $users = $user->where(['id' => $user_id])->first();

            $ddata['first_name'] = $this->request->getPost('first_name');

            $ddata['about'] = $this->request->getPost('about');

            $ddata['last_name'] =$this->request->getPost('last_name');

            $ddata['company_email'] = $this->request->getPost('company_email');
            
            $ddata['city'] = $this->request->getPost('city');

            $ddata['mobile'] = $this->request->getPost('mobile');

            $ddata['company_address'] = $this->request->getPost('company_address');

            $ddata['company_name'] = $this->request->getPost('company_name');
              $ddata['profile_status'] = 1;
            $photo = $this->request->getFile('photo');

          	$jadi = new CoporateUser();

            //$data['profile_photo'] = ($json->gender == 'male') ? "images/male_icon.png" : "images/female_icon.png";

            // if($doctor->image == 'images/male_icon.png' || $doctor->image == 'images/female_icon.png' || $doctor->image == '') {
            //     $data['photo'] = ($json->gender == 'male') ? "images/male_icon.png" : "images/female_icon.png";
            // }
            
            //  if($users->user_type == 'corporate') {
            //  $name = $photo->getRandomName();
            //     $loc = 'images/coporate/';

            //     if($photo->isValid() && !$photo->hasMoved()) {
            //         $photo->move($loc, $name);
            //         $ddata['image'] = $loc . $name;
            //          $jadi->update($corporate->id, $ddata);

            //     }

            //  }
			$id=$jadi->update($corporate->id,$ddata);
				
				//var_dump($id);die();

          // $user_corporate->update($user_id, $ddata);

                

    
            $uddata['name'] = $this->request->getPost('first_name');

            $uddata['email'] = $this->request->getPost('company_email');

            $uddata['username'] =$this->request->getPost('company_email');
            
            $uddata['phone'] = $this->request->getPost('mobile');


            $user_corporate = new CoporateUser();

            $u = $user_corporate->where(['user_id' => $user_id])->first();

          

             $user->update($users->id, $uddata);

            

            return $this->respond(['status' => '200', 'message' => 'corporate Updated']);

            

        }

        catch(Exception $e) {

            return $this->fail(['message' => $e->getMessage()]);

        }

    }

    public function sendVerificationCode($phone)
    {
        $edata['phone'] = $phone;
        $edata['code'] = rand(1000, 9999);
        $edata['date'] = date('Y-m-d');

        $ev = new EmailVerification();
        $items = $ev->where([
            'phone' => $phone
        ])->findAll();

        foreach($items as $item) {
            if($item) {
                $ev->delete($item->id);
            }
        }

        // SMS Script 
        if($ev->insert($edata)) {
            return $edata['code'];
        }
        return false;
    }

    public function verifyUser()
    {
        try {
            $udata = $this->request->getJSON();
            $ev = new EmailVerification();
            $item = $ev->where([
                "phone" => $udata->phone,
                "code" => $udata->code
            ])->orderBy('id', 'DESC')->first();

            if($item) {
                $u = $this->model->where([
                    "phone" => $udata->phone
                ])->first();

                if($u) {
                    $data['phone_verified'] = 1; 
                    $data['status'] = 1;
                    $this->model->update($u->id, $data);

                    $ev->delete($item->id);

                    return $this->respond([

                        "status" => "success",

                        "msg" => "Phone Verified"

                    ]);

                }

                throw new Exception("User not Found");

            }

            else {

                throw new Exception("Invalid Code or Phone no. Try sending verification code again");

            }

        }

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON([

                'status' => 'error', 

                'msg' => $e->getMessage()

            ]);

        }

    }



    public function resendVerificationCode()

    {

        try {

            $fp = $this->request->getJSON();

            $code = $this->sendVerificationCode($fp->mobile);





            return $this->respond([

                'status' => 'success',

                'msg' => 'Verification code send',

                'code' => $code

            ]);

        }

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON([

                'status' => 'error',

                'msg' => $e->getMessage()

            ]);

        }

    }

    public function forget_password()
    {
        try {
            $email = $this->request->getPost('email');
            $user = $this->model->where(['email' => $email])->first();
            if(!$user) {
                throw new Exception("User not found");
            }

            // $otp = new \App\Libraries\Sms();
            // $data = [
            //     "name" => ucfirst('customer'),
            //     "code" => site_url('user/change-password') . '?uid=' . EncryptId($user->id),
            //     "phone" => $user->phone
            // ];

            return $this->respond([
                'status' => 'success',
                'msg' => 'Password Change Link has been sent',
            ]);
            
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function changePassword()
    {
        try {
            $uid = $this->request->getGet('uid');
            $user = $this->model->where(['id' => DecryptId($uid)])->first();
            if(!$user) {
                throw new Exception("User not found");
            }

            if($this->request->getMethod() == 'post') {

            }
            else {
                return view('user/forget_password');
            }
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }


    public function sendSMS()
    {
        //Dear Customer, you have successfully hired ##babysitter## ##nursename## from ##from## to ##to## dated ##bookingdate##. Thank you for booking the service at Yes! maam. For further details Please check the service history.
        $sms = new \App\Libraries\Sms();
        $data = [
            "phone" => "918983301146",
            "babysitter" => "Filipina Babysitter", 
            'nursename' => "Samantha", 
            'from' => "10/10/2022", 
            'to' => "12/10/2022", 
            'bookingdate' => "09/10/2022", 
        ];

        return $sms->booking($data);
    }
    
    /**
     * This Function deletes all records of the User
     * @return string
    */
    public function deleteAccount()
    {
        try {
            $json = $this->request->getJSON();
            $userId = $json->user_id;

            $user = $this->model->where(['id' => $userId])->first();
            if(!$user) {
                throw new Exception('User not Found');
            }
            //return $this->respond(['status' => 'success', 'msg' => 'Your account has been deleted']);
            $model = null; $person = null;
            $doctorB = new \App\Models\Api\DoctorBooking();
            $nurseB = new \App\Models\Api\NurseBook();
            $requirementB = new \App\Models\Api\RequirementBook();
            $serviceB = new \App\Models\Api\ServiceBook();


            if($user->user_type == 'nurse') {
                $model = new \App\Models\Api\Nurse();
                $person = $model->where(['user_id' => $userId])->first();

                if(!$person) {
                    throw new Exception("Doctor not found");
                }

                $nurse = $nurseB->where(['nurse_id' => $person->id])->findAll();
                foreach($nurse as $d) {
                    $nurseB->delete($d->id);
                }

                $req = $requirementB->where(['nurse_id' => $person->id])->findAll();
                foreach($req as $d) {
                    $requirementB->delete($d->id);
                }

                // $service = $serviceB->where(['customer_id' => $person->id])->findAll();
                // foreach($service as $d) {
                //     $serviceB->delete($d->id);
                // }

                $model->delete($person->id);
                $this->model->delete($user->id);
            }
            else if($user->user_type == 'doctor') {
                $model = new \App\Models\Api\Doctor();
                $person = $model->where(['user_id' => $userId])->first();

                if(!$person) {
                    throw new Exception("Doctor not found");
                }

                $doc = $doctorB->where(['doctor_id' => $person->id])->findAll();
                foreach($doc as $d) {
                    $doctorB->delete($d->id);
                }

                $model->delete($person->id);
                $this->model->delete($user->id);
            }
            else if($user->user_type == 'customer') {
                $model = new \App\Models\Api\Customer();
                $person = $model->where(['user_id' => $userId])->first();
                if(!$person) {
                    throw new Exception("Customer not found");
                }
                $doc = $doctorB->where(['customer_id' => $person->id])->findAll();
                foreach($doc as $d) {
                    $doctorB->delete($d->id);
                }

                $nurse = $nurseB->where(['customer_id' => $person->id])->findAll();
                foreach($nurse as $d) {
                    $nurseB->delete($d->id);
                }

                $req = $requirementB->where(['customer_id' => $person->id])->findAll();
                foreach($req as $d) {
                    $requirementB->delete($d->id);
                }

                $service = $serviceB->where(['customer_id' => $person->id])->findAll();
                foreach($service as $d) {
                    $serviceB->delete($d->id);
                }

                $model->delete($person->id);
                $this->model->delete($user->id);
            }
            
            return $this->respond(['status' => 'success', 'msg' => 'Your account has been deleted']);
            
            

        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }
}