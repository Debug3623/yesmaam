<?php

namespace App\Controllers\Api;

use Exception;
use App\Models;
use App\Libraries\Sms;

use App\Models\Api\Nurse;
use App\Models\Api\User;
use App\Libraries\Email;
use App\Models\Api\Customer;
use App\Models\Api\Referral;
use App\Models\Api\Employee;
use App\Models\Api\Settings;
use App\Models\Api\PurchasePlan;
use App\Models\Api\CoporateUser;
use App\Models\Api\Document;
use App\Models\Api\EmailVerification;
use CodeIgniter\RESTful\ResourceController;

class CorporateUserController extends ResourceController
{
    protected $modelName = 'App\Models\Api\Corporate';
    protected $format = 'json';
    public $tab_users = 'users';


    public function login()
    
    {
        
        
         try {
            $json = $this->request->getJSON();
            $phone = $json->mobile;
            $password = $json->password;
            

            //$model = new User();
            $user = $this->model->where([
                'phone' => $phone
            ])->first();

            if(!$user) {
                throw new Exception('No use found');
            }

            if(!password_verify($password, $user->password)) {
                throw new Exception("Phone or Password did not match");
            }

            if($user->phone_verified == 0) {
                throw new Exception('Youe phone is not verified. Verify your phone to proceed further');
            }

            if(!empty($json->registration_id) && $json->registration_id != $user->registration_id) {
                $data['registration_id'] = $json->registration_id;
                $this->model->update($user->id, $data);
            }   

            if($user->user_type == 'customer') {
                $customerModel = new \App\Models\Api\Customer();
                $user->customer = $customerModel->where(['user_id' => $user->id])->first();
            }
            else if($user->user_type == 'nurse') {
                $customerModel = new \App\Models\Api\Nurse();
                $user->customer = $customerModel->where(['user_id' => $user->id])->first();
                $user->customer->dob = $user->customer->date_of_birth;
            }

            else if($user->user_type == 'doctor') {
                $customerModel = new \App\Models\Api\Doctor();
                $user->customer = $customerModel->where(['user_id' => $user->id])->first();
            }
                 else if($user->user_type == 'doctor') {
                $customerModel = new \App\Models\Api\Doctor();
                $user->customer = $customerModel->where(['user_id' => $user->id])->first();
            }

            
            $udata['latitude'] = (isset($json->latitude))?$json->latitude:$user->latitude;
            $udata['longitude'] = (isset($json->longitude))?$json->longitude:$user->longitude;
            $this->model->update($user->id, $udata);

            $settingM = new \App\Models\Api\Settings();
            $setting = $settingM->first();

            return $this->respond([
                'status' => 'success',
                'result' => $user,
                'nurse_bidding_rate' => $setting->nurse_bidding_rate,
                'nurse_hour_rate' => $setting->nurse_hour_rate,
                'babysitter_rate' => $setting->babysitter_rate,
                'video_id' => $setting->video_id
            ]);
     }
         catch(Exception $e) {
             return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage() . '-' . $e->getLine()]);
         }

    }
    
   
    public function user_login()
    {
        try {
            $json = $this->request->getJSON();
            $phone = $json->mobile;
            $password = $json->password;
            

            //$model = new User();
            $user = $this->model->where([
                'phone' => $phone
            ])->first();

            if(!$user) {
                throw new Exception('No use found');
            }

            if(!password_verify($password, $user->password)) {
                throw new Exception("Phone or Password did not match");
            }

            if($user->phone_verified == 0) {
                throw new Exception('Youe phone is not verified. Verify your phone to proceed further');
            }

            if(!empty($json->registration_id) && $json->registration_id != $user->registration_id) {
                $data['registration_id'] = $json->registration_id;
                $this->model->update($user->id, $data);
            }   

            if($user->user_type == 'customer') {
                $customerModel = new \App\Models\Api\Customer();
                $user->customer = $customerModel->where(['user_id' => $user->id])->first();
            }
            else if($user->user_type == 'nurse') {
                $customerModel = new \App\Models\Api\Nurse();
                $user->customer = $customerModel->where(['user_id' => $user->id])->first();
                $user->customer->dob = $user->customer->date_of_birth;
            }

            else if($user->user_type == 'doctor') {
                $customerModel = new \App\Models\Api\Doctor();
                $user->customer = $customerModel->where(['user_id' => $user->id])->first();
            }

            
            $udata['latitude'] = (isset($json->latitude))?$json->latitude:$user->latitude;
            $udata['longitude'] = (isset($json->longitude))?$json->longitude:$user->longitude;
            $this->model->update($user->id, $udata);

            $settingM = new \App\Models\Api\Settings();
            $setting = $settingM->first();

     
            $plans = new \App\Models\Api\PurchasePlan();
            $usersd = $plans->where(['user_id' => $user->id])->first();
            
            
                if($usersd) {
                    
                    $plan=true;
                }
                else
                {
                    $plan=false;
                    
                }
                
         

            return $this->respond([
                'status' => 'success',
                'result' => $user,
                'plan' => $plan,
                'nurse_bidding_rate' => $setting->nurse_bidding_rate,
                'nurse_hour_rate' => $setting->nurse_hour_rate,
                'babysitter_rate' => $setting->babysitter_rate,
                'video_id' => $setting->video_id
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage() . '-' . $e->getLine()]);
        }

    }


     /*
     |----------------------------------------------------------------------
     | FUNCTION @Login FOR LOGGING USER IN
     |----------------------------------------------------------------------
     */
    public function corporate_login()
    {
           try {


            
            
            $mobile = $this->request->getPost('phone');
			$password = (string)$this->request->getPost('password');

			$model = new \App\Models\User();
			$admin = $model->where(['phone' => $mobile])->first();
			//var_dump(password_verify($password, $admin->password)); die();
			if($admin) {
				if(password_verify($password, $admin->password)) {
					
			     return $this->respond([
                'status' => 200,
                'message' => 'Corporate Login Successfully',
                'user_id' => $admin->id,
                'company_name' => $admin->name,
                'company_email' => $admin->email,
                // 'company_address' => $admin->company_address,
                'mobile' => $admin->phone,
               
            ]);
					
				}
				else {
			         throw new Exception("Phone or Password did not match");

				}
			}
			else {
			   throw new Exception('No use found');
			}
            
            
           }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['status' => '401', 'message' => $e->getMessage() . '-' . $e->getLine()]);
        }
    }
    
        public function getCorporateProfile()

    {


        try {
            

            $user_id =$this->request->getPost('user_id');
             
            $user = new \App\Models\Api\CoporateUser();
            $uemail = $user->where(['user_id' =>  $user_id])->first();
            

            if(!$uemail) {

                throw new Exception("Corporate not Found");

            }
            
            
            $plans = new \App\Models\Api\PurchasePlan();
            $planing = $plans->where(['user_id' => $user_id])->orderBy('id','DESC')
                ->limit(1)->find();
                
           if(!empty($planing)){
           foreach($planing as $plans)
           {
               if($plans->payment_status== "completed") {
                    
                  $uemail->plan =true;
                }
                else
                {
                   $uemail->plan=false;
                    
                }   }
            
               
              }else
              {
                {
                   $uemail->plan=false;
                    
                }
                }
           
                     
                 $referral = new Referral();
			  	 $referral_code = $referral->where(['user_id' => $user_id])->first();

                if($referral_code)
                {
                    $uemail->referral_code =$referral_code->referral_code;
                }

            return $this->respond([
                'status' => '200',
                'message' => 'Get Corporate Profile',
                'data' => $uemail,
         
                   
            ]);


        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }
    

    public function corporate_register()
    {
        try {
            $json = $this->request->getJSON();
            
            
            $udata['name'] = $this->request->getPost('company_name');
			$udata['email'] = $this->request->getPost('company_email');
			$udata['username'] = $this->request->getPost('company_email');
			$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
            $udata['user_type'] = 'corporate';
            $udata['phone'] =$this->request->getPost('mobile');
        
            $user = new \App\Models\Api\User();
            $u = $user->where(['phone' =>  $udata['phone']])->first();
            
            $uemail = $user->where(['email' =>  $udata['email']])->first();

            
            $corporate = $user->where(['user_type' => 'corporate'])->first();
            
            
            if($u && $corporate ) {
                throw new Exception("Phone no is already exists");
            }
            
            if($uemail && $corporate)
            {
              throw new Exception("Email is already exists");

            }

            
      	        $docs = new User();
				$user_id=$docs->insert($udata);
			
        	    $doc = $this->request->getFile('document');
                  	//dd($doc);
        			if($doc && $doc->isValid() && !$doc->hasMoved()) {
        				$rules['document'] = [
        					'label' => 'Medical Licence',
        					'rules' => 'uploaded[photo]'
        				];
        			}
        			
        		
        		//Referral Code
        		
        	     $referral_code =str_replace(' ','',strtolower(trim($this->request->getPost('company_name'))).rand(1000,9999)) ;
        	     
        	       $referrals = [
                    'user_id' => $user_id, 
                    'referral_code' => $referral_code, 
                   ];
                   
                 $referral = new Referral();
			  	 $ref_id=$referral->insert($referrals);
			  	 
        		//End Referral Code

				
			
            	$ddata['company_name'] = $this->request->getPost('company_name');
				$ddata['company_address'] = $this->request->getPost('company_address');
				$ddata['company_email'] = $this->request->getPost('company_email');
				$ddata['mobile'] = $this->request->getPost('mobile');
				$ddata['user_id'] = $user_id;
				$ddata['status'] = 1;
				$ddata['available'] = 'No';
				$ddata['confirmed'] = 0;
			    $ddata['phone_verified	'] = 1;
			


				//dd($ddata);
				$doc = new CoporateUser();
				$id=$doc->insert($ddata);
				
				
				
				$corporate = $doc->where(['id' =>  $id])->first();
				$refferal_code = $referral->where(['id' =>  $ref_id])->first();
				
				 
	
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

			
            $otp = new \App\Libraries\Sms();
            $data = [
                "name" => $this->request->getPost('company_name'),
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
            
            $url = 'https://yesmaam.ae/production/public/documents/corporates/';
            $doco= new Document();
            $datass= $doco->select("id,user_id,CONCAT('$url','',filename) as filename")->where(['user_id' => $user_id])->findAll();
          
       
                    

            $settingM = new \App\Models\Api\Settings();
            $setting = $settingM->first();
            return $this->respond([
                'status' => 200,
                'message' => 'Corporate Registerd Successfully',
                'user_id' => $user_id,
                'code' => $data['code'],
             
                'company_name' => $corporate->company_name,
                'company_email' => $corporate->company_email,
                'company_address' => $corporate->company_address,
                'mobile' => $corporate->mobile,
                'referral_code' => $refferal_code->referral_code,
                 
                'user_id' => $corporate->user_id,
                'confirmed' => $corporate->confirmed,
                'available' => $corporate->available,
                'filename' =>$datass
               
                
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
    
    
    
     public function approvelEmployee()
    
    {
        
           try {
                
            $json = $this->request->getJSON();

            $user_id =$this->request->getPost('user_id');
                           
            $user = new Employee();

			$approvel = $user->where(['user_id' => $user_id])->first();
			
		      $userss = new \App\Models\Api\User();
            $u = $userss->where(['id' =>  $user_id])->first();
			
			$sms = new \App\Libraries\Sms();
            $sms->approvedEmployee([
                'phone' => $u->phone,
                "name" => $u->name,
                
            ]);
			  	 
		    if(!$approvel) {

                throw new Exception("User not Found");

            }
            
            	 
        	     
           $referral_codes['confirmed'] =1 ;
        	   
           $user->update($approvel->id,$referral_codes);
         	
           return $this->respond(['status' => '200', 'message' => 'Employee Aprroved successfully']);

               
            
    }
       catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }
        
    }
    
    
     public function approvedEmployee()

    {


        try {
            
             $json = $this->request->getJSON();
            $user_id =$this->request->getPost('user_id');
             
            $user = new \App\Models\Api\Employee();
            $uemail = $user->where(['company_code' =>  $user_id,'confirmed' => '1'])->findAll();
            
        	$userss = new \App\Models\Api\User();
            $u = $userss->where(['id' =>  $user_id])->first();
            
           // var_dump($u);die();
        	
       
        	
        
// 			$otp = new Sms();

//             $data = [

//                 "name" => $u->name,

//                 "code" => "Your profile is approved!",

//                 "phone" => $u->phone

//             ];



//             $response = $otp->sendOTP($data);
            if(!$uemail) {

                  return $this->respond([
                'status' => 200,
                'message' => 'Employee not Found',
                'data' => [],
                
                   
            ]);
                
            }
        
            
            return $this->respond([
                'status' => 200,
                'message' => 'Get Approved Employees',
                'data' => $uemail,
         
                   
            ]);


        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }
        
     public function unApprovedEmployee()

    {


        try {
            

            $user_id =$this->request->getPost('user_id');
             
            $user = new \App\Models\Api\Employee();
            $uemail = $user->where(['company_code' =>  $user_id,'confirmed' => '0'])->findAll();
            

            if(!$uemail) {

                  return $this->respond([
                'status' => 401,
                'message' => 'Employee not Found',
                'data' => [],
                
                   
            ]);
                
            }
        
            
            return $this->respond([
                'status' => 200,
                'message' => 'Get unapproved Employees',
                'data' => $uemail,
         
                   
            ]);


        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }
    
    
    
       public function totalUnApprovedEmployee()

    {


        try {
            

            $user_id =$this->request->getPost('user_id');
             
            $user = new \App\Models\Api\Employee();
            $uemail = $user->where(['company_code' =>  $user_id,'confirmed' => '0'])->countAllResults();
            

            if(!$uemail) {

                  return $this->respond([
                'status' => 200,
                'message' => 'Get Pending Employees',
                'total' => 0
                   
            ]);
                
            }
        
            
            return $this->respond([
                'status' => 200,
                'message' => 'Get Pending Employees',
                'total' => $uemail,
         
                   
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
            
            	     $referral_codes['referral_code'] =str_replace(' ','',strtolower(trim('Yesmam')).rand(1000,9999)) ;
        	     
        	   
            
         	$referral->update($referral_code->id,$referral_codes);

            return $this->respond(['status' => '200', 'message' => 'Referral Code Updated']);

            

        }

        catch(Exception $e) {

            return $this->fail(['message' => $e->getMessage()]);

        }

    }
    
    
    
    
     public function uploadImage() {

          try {
              
            $user_id = $this->request->getPost('user_id');
            $models = new \App\Models\Api\CoporateUser();
            $corporate = $models->where(['id' => $user_id])->first();

            if(!$corporate) {

                throw new Exception("corporate not Found");

            }
            
              $user_corporate = new CoporateUser();
              
              
                 $image = $this->request->getFile('image');

	      	if($image && $image->isValid() && !$image->hasMoved()) {
    				$rules['image'] = [
    					'label' => 'image',
    					'rules' => 'uploaded[photo]'
    				];
    			}
    			
    	  		
    		if($image && $image->isValid() && !$image->hasMoved()) {
					$name = $image->getRandomName();
					$loc = 'images/coporate';

					$image->move($loc, $name);
					$ddata['image'] = 'images/coporate/' . $name;
				}
        

		            $imagesss= $user_corporate->update($corporate->id, $ddata);
		            
		              $corporate = $models->where(['id' => $user_id])->first();
		              
		              
		             $corporate_image= $corporate->image;

                  return $this->respond(['status' => '200', 'message' => 'corporate image uploaded','image'=>$corporate_image]);

              
          }
  
         catch(Exception $e) {

            return $this->fail(['message' => $e->getMessage()]);

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