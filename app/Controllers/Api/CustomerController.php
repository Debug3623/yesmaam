<?php

namespace App\Controllers\Api;

use Exception;
use App\Models\Api\User;
use App\Libraries\Email;
use App\Models\Api\Customer;
use App\Models\EmailVerification;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class CustomerController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Api\Customer';
    protected $format = 'json';

    public function UpdateProfile()
    {
        try {
            $d = $this->request->getJSON();
            //var_dump($d); die();
            $customer = $this->model->where(['user_id' => $d->user_id])->first();
            if(!$customer) {
                throw new Exception("Customer not Found");
            }
            $userModel = new User();
            $user = $userModel->where(['id' => $d->user_id])->first();
            if(!$user) {
                throw new Exception("Invalid User ID");
            } 
            $data['first_name'] = $d->first_name;
            $data['middle_name'] = $d->middle_name;
            $data['last_name'] = $d->last_name;
            $data['email'] = $d->email;
            $data['gender'] = (isset($d->gender))?$d->gender:"male";
            $data['dob'] = date('Y-m-d', strtotime($d->date_of_birth));
            $data['visa_status'] = $d->visa_status;
            $data['emirates_id'] = isset($d->emirates_id)?$d->emirates_id:"";
            $data['insurance_id'] = isset($d->insurance_id)?$d->insurance_id:"";
            $data['emirates_expiry'] = $d->emirates_expiry;
            $data['nationality'] = $d->nationality;
            $data['insurance_company'] = $d->insurance_company;
            $data['passport_no'] = $d->passport_no;
            $data['city'] = $d->city;
            $data['address'] = $d->address;

            if($customer->profile_photo == 'images/male_icon.png' || $customer->profile_photo == 'images/female_icon.png' || $customer->profile_photo == '') {
                $data['profile_photo'] = ($d->gender == 'male') ? "images/male_icon.png" : "images/female_icon.png";
            }

            $this->model->update($customer->id, $data);
            $udata['name'] = $d->first_name;
            $udata['email'] = $d->email;
            //$udata['phone'] = $d->mobile;
            $userModel->update($d->user_id, $udata);
            return $this->respond([
                'status' => 'success',
                'msg' => 'Customer profile updated'
            ]);

        } catch (Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }

    public function uploadPhoto()
    {
        try {
            $user_id = $this->request->getPost('user_id');
            $customerModel = new Customer();
            $customer = $customerModel->where(['user_id' => $user_id])->first();

            if(!$customer) {
                throw new Exception("Invalid User ID");
            }

            $photo = $this->request->getFile('photo');
            if($photo->isValid() && !$photo->hasMoved()) {
                $loc = "images/customers/";
                $name = $photo->getRandomName();

                $photo->move($loc, $name);
                if(!empty($customer->profile_photo) && is_file($customer->profile_photo) && ($customer->profile_photo != 'male_icon.png' || $customer->profile_photo != 'female_icon.png')) {
                    if($customer->profile_photo != 'images/male_icon.png' && $customer->profile_photo != 'images/female_icon.png') {
                        unlink($customer->profile_photo);
                    }
                }

                $data['profile_photo'] = $loc . $name;
                $customerModel->update($customer->id, $data);

                return $this->respond([
                    'status' => 'success', 
                    'msg' => 'Profile Photo Updated',
                    'result' => [
                        'url' => $loc . $name
                    ]
                ]);
            }
        }

        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }

    }

    public function uploadEmirates()
    {
        try {
            $user_id = $this->request->getPost('user_id');
            $customerModel = new Customer();
            $customer = $customerModel->where(['user_id' => $user_id])->first();

            if(!$customer) {
                throw new Exception("Invalid User ID");
            }

            $photo = $this->request->getFile('emirates');
            //dd($photo);
            if($photo->isValid() && !$photo->hasMoved()) {
                $loc = "images/customers/";
                $name = $photo->getRandomName();

                $photo->move($loc, $name);
                if(!empty($customer->emirates_pc) && is_file($customer->emirates_pc)) {
                    unlink($customer->emirates_pc);
                }

                $data['emirates_pc'] = $loc . $name;
                $data['emirates_status'] = 'pending';
                $customerModel->update($customer->id, $data);

                return $this->respond([
                    'status' => 'success', 
                    'msg' => 'Emirates ID Proof Updated',
                    'result' => [
                        'url' => $loc . $name
                    ]
                ]);
            }
        }

        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }

    }


    public function uploadInsurance()
    {
        try {
            $user_id = $this->request->getPost('user_id');
            $customerModel = new Customer();
            $customer = $customerModel->where(['user_id' => $user_id])->first();

            if(!$customer) {
                throw new Exception("Invalid User ID");
            }

            $photo = $this->request->getFile('insurance');
            if($photo->isValid() && !$photo->hasMoved()) {
                $loc = "images/customers/";
                $name = $photo->getRandomName();

                $photo->move($loc, $name);

                if(!empty($customer->insurance_pc) && is_file($customer->insurance_pc)) {
                    unlink($customer->insurance_pc);
                }
                $data['insurance_pc'] = $loc . $name;
                $data['insurance_status'] = 'pending';
                $customerModel->update($customer->id, $data);

                return $this->respond([
                    'status' => 'success', 
                    'msg' => 'Insurance ID Proof Updated',
                    'result' => [
                        'url' => $loc . $name
                    ]
                ]);
            }
        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }

    

    public function acceptedBids($user_id) {

        try {

            $customer = $this->model->where(['user_id' => $user_id])->first();

            if(!$customer) {

                throw new Exception("Invalid User ID");

            }



            $bidModel = new \App\Models\Api\RequirementBook();

            $bids = $bidModel->allAcceptedBids($customer->id);



            return $this->respond(['result' => $bids]);

        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }

    

    public function appointments($userID) {

        try {

            $customerModel = new Customer();

            $customer = $customerModel->where(['user_id' => $userID])->first();

            if(!$customer) {

                throw new Exception("Customer not found");

            }



            $booking = new \App\Models\Api\DoctorBooking();

            $bookings = $booking->getAppointments($customer->id);



            return $this->respond(['result' => $bookings]);

        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }


    public function callCustomer()

    {

        try {

            $json = $this->request->getJSON();

            $bmodel = new \App\Models\Api\DoctorBooking();

            $booking = $bmodel->getBooking($json->booking_id, $json->type);

            //return $this->respond($booking);

            $notification = new \App\Libraries\Notification();



            if($json->type == 'employee') {

                $data = [

                    "first_name" => $booking->c_fname,

                    "last_name" => $booking->c_lname,

                    "call_type" => $booking->call_type,

                    "channel" => $booking->channel_id,

                    "token" => $json->token

                ];

            }

            else {

                $data = [

                    "first_name" => $booking->d_fname,

                    "last_name" => $booking->d_lname,

                    "call_type" => $booking->call_type,

                    "channel" => $booking->channel_id,

                    "token" => $json->token

                ];

            }

            

            //return $this->respond($booking);

            $notification->sendMessage(

                $json->token, 

                $booking->registration_id, 

                $booking->channel_id, 

                $data

            );

            return $this->respond(['msg' => "calling"]);

        }

        catch(Exception $e) {

            return $this->fail([

                'msg' => $e->getMessage(),

                'line' => $e->getMessage()

            ]);

        }

    }
    

    public function callEmployee()

    {

        try {

            $json = $this->request->getJSON();

            $bmodel = new \App\Models\Api\DoctorBooking();

            $booking = $bmodel->getEmployeeBooking($json->booking_id, $json->type);

//var_dump($booking);die();

            $notification = new \App\Libraries\Notification();



            if($json->type == 'employee') {

                $data = [

                     "first_name" => $booking->c_fname,

                    "last_name" => $booking->c_lname,

                    "call_type" => $booking->call_type,

                    "channel" => $booking->channel_id,

                    "token" => $json->token

                ];
        

            }

            else {

                $data = [

                     "first_name" => $booking->d_fname,

                    "last_name" => $booking->d_lname,

                    "call_type" => $booking->call_type,

                    "channel" => $booking->channel_id,

                    "token" => $json->token
                ];
                
   

            }

            
        
                 $notification->sendMessage(

                $json->token, 

                $booking->registration_id, 

                $booking->channel_id, 

                $data

            );
            //return $this->respond($booking);

    

            return $this->respond(['msg' => "calling"]);

        }

        catch(Exception $e) {

            return $this->fail([

                'msg' => $e->getMessage(),

                'line' => $e->getMessage()

            ]);

        }

    }



    public function callFollowUpCustomers()

    {

        try {

            $json = $this->request->getJSON();

            $bmodel = new \App\Models\Api\FollowUp();

            $booking = $bmodel->getFollowUp($json->id,$json->type);


 //var_dump($booking);die();
            //return $this->respond($booking);

            $notification = new \App\Libraries\Notification();



            if($json->type == 'customer') {

                $data = [

                    "first_name" => $booking->c_fname,

                    "last_name" => $booking->c_lname,

                    "channel" => $booking->channel_id,
                    "call_type" =>"video",
                    "token" => $json->token

                ];
                
                       $notification->sendMessage(

                $json->token, 

                $booking->registration_id, 

                $booking->channel_id, 

                $data

            );
 

            }

            else {

                $data = [

                    "first_name" => $booking->d_fname,

                    "last_name" => $booking->d_lname,

                    "channel" => $booking->channel_id,
                    "call_type" =>"video",
                    "token" => $json->token

                ];
                
                       $notification->sendMessage(

                $json->token, 

                $booking->registration_id, 

                $booking->channel_id, 

                $data

            );
 

            }

           
            //return $this->respond($booking);

     

            return $this->respond(['msg' => "calling"]);

        }

        catch(Exception $e) {

            return $this->fail([

                'msg' => $e->getMessage(),

                'line' => $e->getMessage()

            ]);

        }

    }


    public function insuranceStatus($user_id)

    {

        try {

            $customer = $this->model->where(['user_id' => $user_id])->first();

            if(!$customer) {

                throw new Exception("User not Found");

            }



            return $this->respond(['result' => $customer->insurance_status]);

        }

        catch(Exception $e) {

            return $this->fail([

                'msg' => $e->getMessage(),

                'line' => $e->getMessage()

            ]);

        }

    }

    public function nurseBookings()
    {
        try {
            $json = $this->request->getJSON();
            $user = $this->model->where([
                'user_id' => $json->user_id
            ])->first();

            if(!$user) {
                throw new Exception("Invalid customer ID");
            }

            $nbmodel = new \App\Models\Api\NurseBook();
            $bookings = $nbmodel->getCustomerBookings2($user->id);
            return $this->respond([
                'result' => $bookings
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }
}