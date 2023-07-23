<?php

namespace App\Controllers\Api;

use Exception;
use App\Models;
use App\Models\Api\Nurse;
use App\Models\Api\Doctor;
use App\Models\Api\CoporateUser;
use App\Models\Api\Employee;
use App\Models\Api\Referral;
use App\Models\Api\PurchasePlan;
use App\Libraries\Email;
use App\Models\Api\Customer;
use App\Models\Api\EmailVerification;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\Api\User';
    protected $format = 'json';

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

            else if($user->user_type == 'corporate') {
                $corporateModel = new \App\Models\Api\CoporateUser();
                $user->corporate = $corporateModel->where(['user_id' => $user->id])->first();
            }
            
              else if($user->user_type == 'employee') {
                $EmployeeModel = new \App\Models\Api\Employee();
                $user->employee = $EmployeeModel->where(['user_id' => $user->id])->first();
            }
            
            
            
            $plans = new \App\Models\Api\PurchasePlan();
            $usersd = $plans->where(['user_id' => $user->id])->first();
            
            
                if($usersd) {
                    
                    $plan=true;
                }
                else
                {
                    $plan=false;
                    
                }
                     $referral = new Referral();
			  	 $referral_code = $referral->where(['user_id' => $user->id])->first();
			  	 
		
                if($referral_code)
                {
                    $referral_code =$referral_code->referral_code;
                }
            
            $udata['latitude'] = (isset($json->latitude))?$json->latitude:$user->latitude;
            $udata['longitude'] = (isset($json->longitude))?$json->longitude:$user->longitude;
            $this->model->update($user->id, $udata);

            $settingM = new \App\Models\Api\Settings();
            $setting = $settingM->first();

            return $this->respond([
                'status' => 'success',
                'result' => $user,
                'plan' => $plan,
                'referral_code'=>$referral_code,
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

    public function register()
    {
        try {
            $json = $this->request->getJSON();
            $udata['password'] = password_hash($json->password, PASSWORD_DEFAULT, ['cost' => 12]);
            $udata['user_type'] = $json->type;
            $udata['phone'] = $json->mobile;
            $udata['registration_id'] = $json->registration_id;
            $udata['latitude'] = (isset($json->latitude))?$json->latitude:"";
            $udata['longitude'] = (isset($json->longitude))?$json->longitude:"";
            
            $user = new \App\Models\Api\User();
            $u = $user->where(['phone' => $json->mobile])->first();
            
            if($u && $u->phone_verified == 1) {
                throw new Exception("Phone no is already exists");
            }

            $model = null;
            if($json->type == 'customer'):
                $model = new Customer();
                $cdata['mobile'] = $json->mobile;
                $cdata['confirmed'] = 1;
                $cdata['status'] = 1;
                $cdata['gender'] = (isset($json->gender))?$json->gender:"male";
            elseif($json->type == 'doctor'):
                $model = new Doctor();
                $cdata['mobile'] = $json->mobile;
                $cdata['channel_id'] = $json->channel_id;
                $cdata['confirmed'] = 0;
                $cdata['status'] = 0;
                $cdata['gender'] = (isset($json->gender))?$json->gender:"male";
                $cdata['doctor_from'] = 'app';
            elseif($json->type == 'nurse'):
                $model = new Nurse();
                $cdata['phone'] = $json->mobile;
                $cdata['confirmed'] = 0;
                $cdata['status'] = 0;
                $cdata['gender'] = (isset($json->gender))?$json->gender:"male";
                $cdata['nurse_from'] = 'app';
            else:
                throw new Exception("User type Error");
            endif;

            // if(isset($json->gender) && $json->gender == 'male' && $json->type == 'customer') {
            //     $cdata['profile_photo'] = 'images/male_icon.png';
            // }
            // else if(isset($json->gender) && $json->gender == 'female' && $json->type == 'customer') {
            //     $cdata['profile_photo'] = 'images/female_icon.png';
            // }
            // else if(isset($json->gender) && $json->gender == 'male' && $json->type == 'doctor') {
            //     $cdata['photo'] = 'images/male_icon.png';
            // }
            // else if(isset($json->gender) && $json->gender == 'female' && $json->type == 'doctor') {
            //     $cdata['photo'] = 'images/female_icon.png';
            // }
            // else if(isset($json->gender) && $json->gender == 'male' && $json->type == 'nurse') {
            //     $cdata['photo'] = 'images/male_icon.png';
            // }
            // else if(isset($json->gender) && $json->gender == 'female' && $json->type == 'nurse') {
            //     $cdata['photo'] = 'images/female_icon.png';
            // }
            if($json->type == 'customer') {
                if($json->gender == 'male') {
                    $cdata['profile_photo'] = 'images/male_icon.png';
                }
                else {
                    $cdata['profile_photo'] = 'images/female_icon.png';
                }
            }
            else {
                if($json->gender == 'male') {
                    $cdata['photo'] = 'images/male_icon.png';
                }
                else {
                    $cdata['photo'] = 'images/female_icon.png';
                }
            }
            
            //var_dump(($u->phone_verified == 0 || $u->phone_verified == '')); die();
            if($u != null && ($u->phone_verified == 0 || $u->phone_verified == '')) {
                $this->model->update($u->id, $udata);
                $user_id = $u->id;
            }
            else {
                $user_id = $this->model->insert($udata);
            }
            
            $otp = new \App\Libraries\Sms();
            $data = [
                "name" => ucfirst($json->type),
                "code" => rand(1000, 9999),
                "phone" => $json->mobile
            ];

            $response = $otp->sendOTP($data);
            $smsdata = [
                'user_id' => $user_id, 
                'mobile' => $json->mobile, 
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
            
            $customer = $model->where(['user_id' => $user_id])->first();
            if($customer != null && ($u->phone_verified == 0 || $u->phone_verified == '')) {
                $model->update($customer->id, $cdata);
            }
            else {
                $model->insert($cdata);
            }
            
            $settingM = new \App\Models\Api\Settings();
            $setting = $settingM->first();
            return $this->respond([
                'status' => 'success',
                'msg' => 'Registered',
                'user_id' => $user_id,
                'code' => $data['code'],
                'profile_photo' => ($json->gender == 'Male' || $json->gender == 'male')? "images/male_icon.png":"images/female_icon.png",
                'nurse_bidding_rate' => $setting->nurse_bidding_rate,
                'nurse_hour_rate' => $setting->nurse_hour_rate,
                'babysitter_rate' => $setting->babysitter_rate,
                'video_id' => $setting->video_id
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error', 
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
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