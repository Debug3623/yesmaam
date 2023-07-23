<?php
namespace App\Controllers\Api;

use Exception;
use App\Models\Api\User;
use App\Models\Api\Order;
use App\Models\Api\Settings;
use App\Models\Api\Customer;
use App\Models\Api\Employee;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class DoctorBookingController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Api\DoctorBooking';
    protected $format = 'json';

    public function allBookings(int $id)
    {
        try {
            $userModel = new User();
            $user = $userModel->where(['id' => $id])->first();
            if(!$user) {
                throw new Exception("User not Found");
            }
            $item = null;
            $booking = new \App\Models\Api\DoctorBooking();
            switch($user->user_type) {
                case "customer":
                    $model = new Customer();
                    $item = $model->where(['user_id' => $user->id])->first();
                    $bookings = $booking->getAllBookingsCustomers($item->id, $user->user_type);
                break;
                case "doctor":
                    $model = new \App\Models\Api\Doctor();
                    $item = $model->where(['user_id' => $user->id])->first();
                    $bookings = $booking->getAllBookingsNurses($item->id, $user->user_type);
                break;
            }
            
            
            return $this->respond(['status' => 200, 'result' => $bookings]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }
    
    
      public function allEmployeeBookings(int $id)
    {
        try {
            $userModel = new User();
            $user = $userModel->where(['id' => $id])->first();
            if(!$user) {
                throw new Exception("User not Found");
            }
            //var_dump($user);die();
       
            $item = null;
            $booking = new \App\Models\Api\DoctorBooking();
            switch($user->user_type) {
                case "employee":
                    $model = new \App\Models\Api\Employee();
                    $item = $model->where(['user_id' => $user->id])->first();
                    
                
                    $bookings = $booking->getAllBookingsEmployee($user->id, $user->user_type);
                break;
        
            }
            
            
            return $this->respond(['status' => 200, 'result' => $bookings]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }
    
     public function bookingCustomerHistory()
    {
        try {
            
 
            
            $customer_id = $this->request->getPost('customer_id');

            $customer = new \App\Models\Api\Customer();
            
             $bookings= $customer->distinct()->
             select('doctor_bookings.*,customers.user_id, customers.first_name AS c_fname, 
                    customers.last_name AS c_lname, customers.profile_photo')
                ->where('doctor_bookings.customer_id',$customer_id)
                ->where('doctor_bookings.prescription !=','')
                ->join('doctor_bookings','doctor_bookings.customer_id=customers.id')
                ->findAll();
            
            return $this->respond(['status' => 200, 'message' => $bookings]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }
    
     public function bookingCorporateHistory()
    {
        try {
            
 
            
            $user_id= $this->request->getPost('user_id');

            $customer = new \App\Models\Api\Employee();
            
             $bookings= $customer->distinct()->
             select('doctor_bookings.*,employees.user_id, employees.fname AS c_fname, 
                    employees.lname AS c_lname, employees.image')
                ->where('doctor_bookings.user_id',$user_id)
                ->where('doctor_bookings.prescription !=','')
                ->join('doctor_bookings','doctor_bookings.user_id=employees.user_id')
                ->findAll();
            
            return $this->respond(['status' => 200, 'message' => $bookings]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }
    
    public function bookDoctor()
    {
        try {
            //throw new Exception("Error ABC");
            $json = $this->request->getJSON();
            
            
          
            //echo($json->booking->user_id); die();

            $model = new Customer();
            $booking = new \App\Models\Api\DoctorBooking();

            $customer = $model->where([
                'user_id' => $json->user_id
            ])->first();

            if(!$customer) {
                throw new Exception("Customer not found");
            }
            
           

            $data['service_date'] = $json->service_date;
            $data['service_time'] = $json->service_time;
            $data['free_leave'] = $json->free_leave;
            $data['dha_leave'] = $json->dha_leave;
            $data['delivery_medicine'] = $json->delivery_medicine;
            $data['remarks'] = $json->remarks;
            $data['doctor_id'] = $json->doctor_id;
            $data['customer_id'] = $customer->id;
            $data['booking_date'] = date('Y-m-d');
            $data['appointment'] = $json->appointment;
            $data['channel_id'] = $json->channel_id;
            
            
            $data['status'] = "pending";
            
            // if($customer->insurance_status == 'not available' 
            //     || $customer->insurance_status == 'pending' 
            //     || $customer->insurance_status == null) {

            //     $data['insurance_no'] = $json->insurance_id;
            //     $data['emirates_id'] = $json->emirates_id;
            //     $data['call_type'] = $json->call_type;
            // }
            // else {
                $data['insurance_no'] = $customer->insurance_id;
                $data['emirates_id'] = $customer->emirates_id;
                $data['call_type'] = 'video';
            //}
            
            if(!$booking->isDoctorAvailable($data['doctor_id'], $data['service_date'], $data['service_time'])) {
                throw new Exception("Doctor is not available");
            }

            $set = new Settings();
            $setting = $set->first();
            
            
            $odata['payment_type'] = $json->payment_method;
            
            if($data['dha_leave'] == "Yes" && $customer->insurance_status == "verified")
            {
                
              
               // $amounts=80;
                 $amounts=80;
                
            }
            elseif($data['dha_leave'] == "No" && $customer->insurance_status != "verified")
            {
                
                //$amounts=49; 
                     $amounts=49;
                
            }
            elseif($data['dha_leave'] == "No" && $customer->insurance_status == "verified")
            {
                 
                $amounts=0;
                
            }elseif($data['dha_leave'] == "Yes" && $customer->insurance_status != "verified")
            {
                 
                // $amounts=129;
                     $amounts=129;
                
                
            }
            
            $img=$json->filename;
              $file_base64=$json->file_base64;
            
            
            if($img=="")
            {
                $data['filename'] = "slider.png";

            }
            else
            {
                
            $fileExt = pathinfo($img, PATHINFO_EXTENSION);
  
            $image = base64_decode($file_base64);
        	$image_name = md5(uniqid(rand(), true));
        	
        	
        	$filename = $image_name . '.' . $fileExt;
        	$path = 'images/employee/';
        	file_put_contents($path . $filename, $image);
                    
             $data['filename']=$filename;
                    
            }
                         
                         
             //var_dump($data);die();  
            $odata['customer_id'] = $customer->id;
            $odata['amount'] = $amounts;
            $odata['order_date'] = date('Y-m-d H:i:s', time());
            $odata['order_id'] = 'YMDO' . date('ymd') . uniqid();
            $odata['order_for'] = 'doctor';
            $odata['item_id'] = $json->doctor_id;
            $odata['payment_id'] = '';
            $odata['payment_status'] = 'Pending';
            $odata['order_status'] = 'progress';


            if($customer->insurance_status == 'not available' || $customer->insurance_status == 'pending' || $customer->insurance_status == null ||  $customer->insurance_status == 'verified' || $customer->insurance_status == 'failed') {
                $odata['billing_firstname'] = $customer->first_name;
                $odata['billing_lastname'] = $customer->last_name;
                $odata['billing_email'] = $customer->email;
                $odata['billing_address'] = $customer->address;
                $odata['billing_city'] = $customer->city;
                $odata['billing_country_code'] = 'AED';
 
                $d = $this->DoctorCardPayment($odata);
                //var_dump($d); die();
                if($d == 'error') {
                    throw new Exception("Payment Server is not responding. Try again after some time");
                }
                //$d['order_reference'] = uniqid();
                $order = new Order();
                if(is_object($d)) {
                    $odata['order_id'] = $d->order_reference;
                }
                else {
                    $odata['order_id'] = $d['order_reference'];
                }
                
                //dd($data['order_id']);
                $id = $order->insert($odata);
                
            if($amounts==0)
                {
                    
                         
            $docModel = new \App\Models\Api\Doctor();
            $doc = $docModel->where(['id' => $json->doctor_id])->first();
            
            $usermodel = new \App\Models\Api\User();
            $user = $usermodel->where(['id' => $doc->user_id])->first();
            
             $notification = new \App\Libraries\Notification();
                $notification->sendMessage($json->token, $user->registration_id, $json->channel_id, [
                    'first_name' => $customer->first_name, 
                    'last_name' => $customer->last_name, 
                    'call_type'=> $json->call_type
                    ]
                );
                        
                 $nb = new \App\Models\Api\DoctorBooking();
                $data['status'] = 'pending';
                $data['order_id'] = $id;
                $data['token'] = $json->token;
                $data['total_amount'] = $amounts;
                
                // var_dump($datas);die();
                $booking_id = $nb->insert($data);
                return $this->respond([
                    'status' => 'success', 
                    'msg' => 'Doctor Appointment Booked',
                    'booking_id' => $id,
                    "appointment" => "false"
                ]);
    
                }
                else
                {
                    
                    
                 $nb = new \App\Models\Api\DoctorBooking();
                $data['status'] = 'progress';
                $data['order_id'] = $id;
                $data['token'] = $json->token;
                $data['total_amount'] = $amounts;
                $booking_id = $nb->insert($data);
                return $this->respond([
                    'redirect_link' => $d['paymentLink'],
                    'booking_id' => $id
                ]);
                }

     

                // return $this->respond([
                //     'redirect_link' => $d['paymentLink'],
                //     'booking_id' => $id
                // ]);
            }
            else {
                $cmodel = new Customer();
                $cus = $cmodel->where(['user_id' => $json->user_id])->first();
                if(!$cus) {
                    throw new Exception("Customer not Found");
                }
                $odata['billing_firstname'] = $cus->first_name;
                $odata['billing_lastname'] = $cus->last_name;
                $odata['billing_email'] = $cus->email;
                $odata['billing_address'] = $cus->address;
                $odata['billing_city'] = $cus->city;
                $odata['billing_country_code'] = 'AED';
            }
            //var_dump($data); die();
            $order = new Order();
            $oid = $order->insert($odata);
            $data['order_id'] = $oid;

            // if($data['insurance_no'] != null) {
            //     $data['status'] = 1;
            // }
            // else {
            //     $data['status'] = 0;
            // }
            
            $nb = new \App\Models\Api\DoctorBooking();
            // if($json->appointment == "true") {
                $data['status'] = 'pending';
            // }
            // else {
            //     $data['status'] = 'progress';
            // }
            
            $data['order_id'] = $oid;
            $data['token'] = $json->token;
            $data['total_amount'] = $amounts;
            $booking_id = $nb->insert($data);
            //$booking->insert($data);
            
            $docModel = new \App\Models\Api\Doctor();
            $doc = $docModel->where(['id' => $json->doctor_id])->first();
            
            $usermodel = new \App\Models\Api\User();
            $user = $usermodel->where(['id' => $doc->user_id])->first();
            
            
            if(!$user) {
                throw new Exception("Doctor not registered");
            }
            //var_dump($json->appointment); die();
            if($json->appointment == "true") {
                return $this->respond(['status' => 'success', 'msg' => 'Doctor Appointment Booked for future', 'booking_id' => $oid, "appointment" => "true"]);
            }
            else {
                $notification = new \App\Libraries\Notification();
                $notification->sendMessage($json->token, $user->registration_id, $json->channel_id, [
                    'first_name' => $customer->first_name, 
                    'last_name' => $customer->last_name, 
                    'call_type'=> $json->call_type
                    ]
                );
                
                return $this->respond([
                    'status' => 'success', 
                    'msg' => 'Doctor Appointment Booked',
                    'booking_id' => $oid,
                    "appointment" => "false"
                ]);
            }

        }   
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error', 
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }
    
    
    
     public function bookEmployee()
    {
        try {
            //throw new Exception("Error ABC");
            $json = $this->request->getJSON();
            //echo($json->booking->user_id); die();

            $model = new  Employee();
            $booking = new \App\Models\Api\DoctorBooking();

            $customer = $model->where([
                'user_id' => $json->user_id
            ])->first();
            
      

            if(!$customer) {
                throw new Exception("User not found");
            }

            $data['service_date'] = $json->service_date;
            $data['service_time'] = $json->service_time;
            $data['doctor_id'] = $json->doctor_id;
            $data['user_id'] = $customer->user_id;
            $data['free_leave'] = $json->free_leave;
            $data['dha_leave'] = $json->dha_leave;
            $data['delivery_medicine'] = $json->delivery_medicine;
            $data['remarks'] = $json->remarks;
            $data['booking_date'] = date('Y-m-d');
            $data['appointment'] = $json->appointment;
            $data['channel_id'] = $json->channel_id;
            
            
            $data['status'] = "pending";
            
            // if($customer->insurance_status == 'not available' 
            //     || $customer->insurance_status == 'pending' 
            //     || $customer->insurance_status == null) {

            //     $data['insurance_no'] = $json->insurance_id;
            //     $data['emirates_id'] = $json->emirates_id;
            //     $data['call_type'] = $json->call_type;
            // }
            // else {
                $data['insurance_no'] = $customer->insurance_id;
                $data['call_type'] = 'video';
            //}
            
            if(!$booking->isDoctorAvailable($data['doctor_id'], $data['service_date'], $data['service_time'])) {
                throw new Exception("Doctor is not available");
            }

            $set = new Settings();
            $setting = $set->first();
            
         if($data['dha_leave'] == "Yes" )
            {
                
               
                $amounts=80;
                
            }
            else
            {
                
                $amounts=0; 
            }
            
            $dataURL=$json->filename;
               if($dataURL=="")
            {
                $data['filename'] = "slider.png";

            }
            else
            {
           
            $dataURL = str_replace('data:image/png;file_base64,', '', $dataURL);
            $dataURL = str_replace(' ', '+', $dataURL);
            $image = base64_decode($dataURL);
            $filename = $dataURL; //renama file name based on time
        
          
            file_put_contents('images/employee/'. $filename, $image);
        
            $data['filename'] = $filename;
            }

            $odata['user_id'] = $customer->user_id;
            $odata['amount'] = $amounts;
            $odata['payment_type'] = $json->payment_method;
            $odata['order_date'] = date('Y-m-d H:i:s', time());
            $odata['order_id'] = 'YMDO' . date('ymd') . uniqid();
            $odata['order_for'] = 'doctor';
            $odata['item_id'] = $json->doctor_id;
            $odata['payment_id'] = '';
            $odata['payment_status'] = 'Pending';
            $odata['order_status'] = 'progress';


            if($customer->insurance_status == 'not available' || $customer->insurance_status == 'pending' || $customer->insurance_status == null || $customer->insurance_status == 'failed') {
                $odata['billing_firstname'] = $customer->fname;
                $odata['billing_lastname'] = $customer->lname;
                $odata['billing_email'] = "mjawadsagheer@gmail.com";
                $odata['billing_address'] = $customer->address;
                $odata['billing_city'] = $customer->city;
                $odata['billing_country_code'] = 'AED';
                
                
                //var_dump($odata);die();

                $d = $this->EmployeeCardPayment($odata);
                //var_dump($d); die();
                if($d == 'error') {
                    throw new Exception("Payment Server is not responding. Try again after some time");
                }
               //  var_dump($d);die();
                //$d['order_reference'] = uniqid();
                $order = new Order();
                if(is_object($d)) {
                    $odata['order_id'] = $d->order_reference;
                }
                else {
                    $odata['order_id'] = $d['order_reference'];
                }
                
                //dd($data['order_id']);
                $id = $order->insert($odata);

                $nb = new \App\Models\Api\DoctorBooking();
                if($amounts==0)
                {
                    $data['status'] = 'pending';

                }
                else
                {
                    $data['status'] = 'progress';

                }
                
                
                $data['order_id'] = $id;
                $data['token'] = $json->token;
                $data['total_amount'] = $amounts;
                
                $booking_id = $nb->insert($data);


                if($amounts==0)
                {
                    
                         
            $docModel = new \App\Models\Api\Doctor();
            $doc = $docModel->where(['id' => $json->doctor_id])->first();
            
            
            
            $usermodel = new \App\Models\Api\User();
            $user = $usermodel->where(['id' => $doc->user_id])->first();
            
        
            
             $notification = new \App\Libraries\Notification();
                $notification->sendMessage($json->token, $user->registration_id, $json->channel_id, [
                    'first_name' => $customer->fname, 
                    'last_name' => $customer->lname, 
                    'call_type'=> $json->call_type
                    ]
                );
                
                return $this->respond([
                    'status' => 'success', 
                    'msg' => 'Doctor Appointment Booked',
                     'order_id' => $id,
                    "appointment" => "false"
                ]);
    
                }
                else
                {
                return $this->respond([
                    'redirect_link' => $d['paymentLink'],
                    'order_id' => $id
                ]);
                }
            }
            else {
                $cmodel = new Employee();
                $cus = $cmodel->where(['user_id' => $json->user_id])->first();
                if(!$cus) {
                    throw new Exception("Customer not Found");
                }
                $odata['billing_firstname'] = $cus->fname;
                $odata['billing_lastname'] = $cus->lname;
                //$odata['billing_email'] = $cus->email;
                $odata['billing_address'] = $cus->address;
                $odata['billing_city'] = $cus->city;
                $odata['billing_country_code'] = 'AED';
            }
            //var_dump($data); die();
            $order = new Order();
            
            
            $oid = $order->insert($odata);
            $data['order_id'] = $oid;

            // if($data['insurance_no'] != null) {
            //     $data['status'] = 1;
            // }
            // else {
            //     $data['status'] = 0;
            // }
            
            $nb = new \App\Models\Api\DoctorBooking();
            // if($json->appointment == "true") {
                $data['status'] = 'pending';
            // }
            // else {
            //     $data['status'] = 'progress';
            // }
            
            $data['order_id'] = $oid;
            $data['token'] = $json->token;
            $data['total_amount'] = $amounts;
            $booking_id = $nb->insert($data);
            //$booking->insert($data);
            
            $docModel = new \App\Models\Api\Doctor();
            $doc = $docModel->where(['id' => $json->doctor_id])->first();
            
            $usermodel = new \App\Models\Api\User();
            $user = $usermodel->where(['id' => $doc->user_id])->first();
            
            if(!$user) {
                throw new Exception("Doctor not registered");
            }
            //var_dump($json->appointment); die();
            if($json->appointment == "true") {
                return $this->respond(['status' => 'success', 'msg' => 'Doctor Appointment Booked for future', 'booking_id' => $oid, "appointment" => "true"]);
            }
            else {
                $notification = new \App\Libraries\Notification();
                $notification->sendMessage($json->token, $user->registration_id, $json->channel_id, [
                    'first_name' => $customer->fname, 
                    'last_name' => $customer->lname, 
                    'call_type'=> $json->call_type
                    ]
                );
                
                return $this->respond([
                    'status' => 'success', 
                    'msg' => 'Doctor Appointment Booked',
                    'order_id' => $oid,
                    "appointment" => "false"
                ]);
            }

        }   
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error', 
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }
    
    function invokeCurlRequest($type, $url, $headers, $post) {
            
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if ($type == "POST") {
        
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        
        }

        $server_output = curl_exec ($ch);
        curl_close ($ch);
        
        return $server_output;
        
    } 
    
    
    
    
    public function EmployeeCardPayment($data)
    {
        try {


	        set_time_limit(0);
            // Test Keys
	       // $outletRef       = "57af269c-f285-4757-a6cc-9bc5451cc143"; //  
	       // $apikey          = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
	        

            // Live Keys
        //     $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384";
	       // $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";
	                                
	       $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"3024a0f5-a490-47dd-99ce-2e92ce322384";
	        $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";


	       // Test URLS 
	       // $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
	       // $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        // LIVE URLS 
	        $idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
	        $txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        $tokenHeaders  = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
	        $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
	        //var_dump($tokenResponse); die();
	        $tokenResponse = json_decode($tokenResponse);
            //dd($tokenResponse);

	        $access_token  = $tokenResponse->access_token;
	        //var_dump($access_token); die();

	        $order = array();   

	        $order['action']= "SALE";                                        // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
	        $order['amount']['currencyCode'] = "AED";                           // Payment currency ('AED' only for now)
	        $order['amount']['value'] = $data['amount'] * 100;                                   // Minor units (1000 = 10.00 AED)
	        $order['language'] = "en";                           // Payment page language ('en' or 'ar' only)
	        $order['emailAddress'] = $data['billing_email'];      
	        $order['billingAddress']['firstName'] = $data['billing_firstname'];      
	        $order['billingAddress']['lastName']  = $data['billing_lastname'];      
	        $order['billingAddress']['address1']  = $data['billing_address'];      
	        $order['billingAddress']['city']      = $data['billing_city'];      
	        $order['billingAddress']['countryCode'] = "USA";      
	                                          
	        $order['merchantOrderReference'] = time();
	        $order['merchantAttributes']['redirectUrl'] = site_url('api/payment/employee/success'); //site_url('payment/doctor/success')
	        $order['merchantAttributes']['skipConfirmationPage'] = true;
	        $order['merchantAttributes']['cancelUrl']   = site_url('api/payment/employee/fail'); //site_url('payment/doctor/failed')
	        $order['merchantAttributes']['cancelText']  = 'Cancel';
	        //dd($order);
	        $order = json_encode($order);  

	        $orderCreateHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
	        //$orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
	        $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
	        //var_dump($orderCreateResponse); die();

	        $orderCreateResponse = json_decode($orderCreateResponse);
	        //var_dump($orderCreateResponse); die();

            if(!$orderCreateResponse || !isset($orderCreateResponse->_links)) {
                return "error";
            }
	        $d['paymentLink'] = $orderCreateResponse->_links->payment->href; 
	        $d['order_reference'] = $orderCreateResponse->reference;
	        return $d;

    	}
    	catch(\Exception $e) {
    		//die("Error: " . $e->getMessage());
            return $this->fail(['msg' => $e->getMessage()]);
    	}
        //return header("Location: ".$paymentLink); 

    }
    

    public function DoctorCardPayment($data)
    {
        try {


	        set_time_limit(0);
            // Test Keys
	       // $outletRef       = "57af269c-f285-4757-a6cc-9bc5451cc143"; //  
	       // $apikey          = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
	        

            // Live Keys
        //     $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384";
	       // $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";
	                                
	       $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"3024a0f5-a490-47dd-99ce-2e92ce322384";
	        $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";


	       // Test URLS 
	       // $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
	       // $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        // LIVE URLS 
	        $idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
	        $txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        $tokenHeaders  = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
	        $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
	        //var_dump($tokenResponse); die();
	        $tokenResponse = json_decode($tokenResponse);
            //dd($tokenResponse);

	        $access_token  = $tokenResponse->access_token;
	        //var_dump($access_token); die();

	        $order = array();   

	        $order['action']= "SALE";                                        // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
	        $order['amount']['currencyCode'] = "AED";                           // Payment currency ('AED' only for now)
	        $order['amount']['value'] = $data['amount'] * 100;                                   // Minor units (1000 = 10.00 AED)
	        $order['language'] = "en";                           // Payment page language ('en' or 'ar' only)
	        $order['emailAddress'] = $data['billing_email'];      
	        $order['billingAddress']['firstName'] = $data['billing_firstname'];      
	        $order['billingAddress']['lastName']  = $data['billing_lastname'];      
	        $order['billingAddress']['address1']  = $data['billing_address'];      
	        $order['billingAddress']['city']      = $data['billing_city'];      
	        $order['billingAddress']['countryCode'] = "USA";      
	                                          
	        $order['merchantOrderReference'] = time();
	        $order['merchantAttributes']['redirectUrl'] = site_url('api/payment/doctor/success'); //site_url('payment/doctor/success')
	        $order['merchantAttributes']['skipConfirmationPage'] = true;
	        $order['merchantAttributes']['cancelUrl']   = site_url('api/payment/doctor/fail'); //site_url('payment/doctor/failed')
	        $order['merchantAttributes']['cancelText']  = 'Cancel';
	        //dd($order);
	        $order = json_encode($order);  

	        $orderCreateHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
	        //$orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
	        $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
	        //var_dump($orderCreateResponse); die();

	        $orderCreateResponse = json_decode($orderCreateResponse);
	        //var_dump($orderCreateResponse); die();

            if(!$orderCreateResponse || !isset($orderCreateResponse->_links)) {
                return "error";
            }
	        $d['paymentLink'] = $orderCreateResponse->_links->payment->href; 
	        $d['order_reference'] = $orderCreateResponse->reference;
	        return $d;

    	}
    	catch(\Exception $e) {
    		//die("Error: " . $e->getMessage());
            return $this->fail(['msg' => $e->getMessage()]);
    	}
        //return header("Location: ".$paymentLink); 

    }
    
    

    public function isDoctorAvailable()
    {
        try {
            $json = $this->request->getJSON();
            $dr_id = $json->doctor_id;
            $date = $json->booking_date;
            $time = $json->booking_time;

            if(!$this->model->isDoctorAvailable($dr_id, $date, $time)) {
                throw new Exception("Doctor is not available");
            }
            return $this->respond([
                'status' => 'success',
                'msg' => 'Doctor is Available'
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error', 
                'msg' => $e->getMessage()
            ]);
        }
    }
    
    public function changeStatus()
    {
        try {
            $json = $this->request->getJSON();
            $data['status'] = ($json->status == "complete" || $json->status == "completed") ? "complete" : "";
            $booking = $this->model->where([
                'order_id' => $json->booking_id
            ])->first();
            
            if(!$booking) {
                // $booking = $this->model->where([
                //     'order_id' => $json->booking_id
                // ])->first();
                if(!$booking) {
                    throw new Exception("Booking not found");
                }
            }
            // var_dump($booking); die(); 
            $this->model->update($booking->id, $data);

            return $this->respond(['status' => 'success', 'msg' => 'Status Updated']);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }
    }

    public function uploadPrescription()
    {
        try {
            $booking_id = $this->request->getPost('booking_id');
            $file = $this->request->getFile('file');
            if(!$file->isValid() && $file->hasMoved()) {
                throw new Exception('File Uploading Error');
            }

            $booking = $this->model->where(['id' => $booking_id])->first();
            
            if(!$booking) {
                throw new Exception("Invalid Booking ID");
            }

            $loc = 'documents/prescriptions/';
            $name = $file->getRandomName(); 
            if($file->move($loc, $name)) {
                if(is_file($booking->prescription)) {
                    unlink($booking->prescription);
                }
                $this->model->update($booking->id, ['prescription' => $loc.$name]);
            }

            return $this->respond(['status' => 'success', 'msg' => 'Prescription Uploaded']);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage(), 'line' => $e->getLine()]);
        }
    }

    public function removePrescription()
    {
        try {
            $json = $this->request->getJSON();
            $booking_id = $json->booking_id;
            $booking = $this->model->where(['order_id' => $booking_id])->first();
            //var_dump($booking); die();
            if(!$booking) {
                throw new Exception("Invalid Booking ID");
            }

            if(is_file($booking->prescription)) {
                unlink($booking->prescription);
            }

            $this->model->update($booking->id, ['prescription' => '']);

            return $this->respond(['status' => 'success', 'msg' => 'Prescription Removed']);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage(), 'line' => $e->getLine()]);
        }
    }
}
