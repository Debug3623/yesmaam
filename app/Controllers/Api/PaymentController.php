<?php
namespace App\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Api\Doctor;
use App\Models\Api\Customer;
use App\Models\Api\DoctorBooking;
use CodeIgniter\RESTful\ResourceController;

Class PaymentController extends ResourceController
{

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
    
    
        public function planSuccess()
    {
        try {
            
            // Test Keys
            // $outletRef 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";       
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
        
            $orderResponse = (array)json_decode($orderResponse);
            //dd($orderResponse);
            $data['payment_reference'] = $orderResponse['reference'];
            $data['payment_status'] = 'completed';
            
            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse['reference']])->first();
            
            if($o) {
                $order->update($o->id, $data);
            } 

            $nb = new \App\Models\Api\PurchasePlan();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
      
            if($nurseB) {
                $nbd['payment_status'] = 'completed';
                $nb->update($nurseB->id, $nbd);
            }


            $email = new \App\Libraries\Email();

            $customer = new \App\Models\Api\CoporateUser();
            $customer = $customer->where(['user_id' => $o->user_id])->first();
            
           // var_dump($customer);die();


            $nurse = new \App\Models\Api\Doctor();
            $nurse = $nurse->where(['id' => $o->item_id])->first();
            
            $userModel = new \App\Models\Api\User();
            $user = $userModel->where(['id' => $customer->user_id])->first();
        
            $setting = new \App\Models\Settings();
        
            $data['item'] = $nurse;
            $data['customer'] = $customer;
            $data['order'] = $o;
            $data['setting'] = $setting->first();


            $sms = new \App\Libraries\Sms();
            $sms->booking([
                'phone' => $customer->mobile
            ]);

 
            return view('payment/doctor_success');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }

    public function doctorSuccess()
    {
        try {
            
            // Test Keys
            // $outletRef 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";       
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
        
            $orderResponse = (array)json_decode($orderResponse);
            //dd($orderResponse);
            $data['payment_reference'] = $orderResponse['reference'];
            $data['payment_status'] = 'completed';
            
            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse['reference']])->first();
            
            if($o) {
                $order->update($o->id, $data);
            } 

            $nb = new \App\Models\Api\DoctorBooking();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            //var_dump($nurseB); die();
            if($nurseB) {
                $nbd['status'] = 'pending';
                $nb->update($nurseB->id, $nbd);
            }


            $email = new \App\Libraries\Email();

            $customer = new \App\Models\Api\Customer();
            $customer = $customer->where(['id' => $o->customer_id])->first();
            
           // var_dump($customer);die();


            $nurse = new \App\Models\Api\Doctor();
            $nurse = $nurse->where(['id' => $o->item_id])->first();
            
            $userModel = new \App\Models\Api\User();
            $user = $userModel->where(['id' => $nurse->user_id])->first();
        
            $setting = new \App\Models\Settings();
        
            $data['item'] = $nurse;
            $data['customer'] = $customer;
            $data['order'] = $o;
            $data['setting'] = $setting->first();

            // $cbody = view('templates/doctor_order_success', $data);
            // $nbody = view('templates/doctor_order_success', $data);
            // $ybody = view('templates/doctor_order_success', $data);
        
            // $email->sendMail($customer->email, 'Booking Summary', $cbody);

            // $email->sendMail($nurse->email, 'Booking Summary', $nbody);
            // $email->sendMail('admin@yesmaam.ae', 'Booking Summary', $ybody);
            //var_dump(); die();

            $sms = new \App\Libraries\Sms();
            $sms->booking([
                'phone' => $customer->mobile
            ]);

            if($nurseB->appointment == 'true') {
                return view('payment/doctor_success');
            }
            $notification = new \App\Libraries\Notification();
            $notification->sendMessage($nurseB->token, $user->registration_id, $nurseB->channel_id, ['first_name' => $customer->first_name, 'last_name' => $customer->last_name, 'call_type'=> $nurseB->call_type]);

            return view('payment/doctor_success');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }
    
    
    
        public function employeeSuccess()
    {
        
        
        try {
            
            // Test Keys
            // $outletRef 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";       
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
        
            $orderResponse = (array)json_decode($orderResponse);
            //dd($orderResponse);
            $data['payment_reference'] = $orderResponse['reference'];
            $data['payment_status'] = 'completed';
            
            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse['reference']])->first();
             
            if($o) {
                $order->update($o->id, $data);
            } 

            $nb = new \App\Models\Api\DoctorBooking();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            //var_dump($nurseB); die();
            if($nurseB) {
                $nbd['status'] = 'pending';
                $nb->update($nurseB->id, $nbd);
            }


            $email = new \App\Libraries\Email();

            $customer = new \App\Models\Api\Employee();
            $customer = $customer->where(['user_id' => $o->user_id])->first();
        

            $nurse = new \App\Models\Api\Doctor();
            $nurse = $nurse->where(['id' => $o->item_id])->first();
            
            $userModel = new \App\Models\Api\User();
            $user = $userModel->where(['id' => $nurse->user_id])->first();
        
            $setting = new \App\Models\Settings();
        
            $data['item'] = $nurse;
            $data['customer'] = $customer;
            $data['order'] = $o;
            $data['setting'] = $setting->first();

            // $cbody = view('templates/doctor_order_success', $data);
            // $nbody = view('templates/doctor_order_success', $data);
            // $ybody = view('templates/doctor_order_success', $data);
        
            // $email->sendMail($customer->email, 'Booking Summary', $cbody);

            // $email->sendMail($nurse->email, 'Booking Summary', $nbody);
            // $email->sendMail('admin@yesmaam.ae', 'Booking Summary', $ybody);
            //var_dump(); die();

            $sms = new \App\Libraries\Sms();
            $sms->booking([
                'phone' => $customer->mobile
            ]);

            if($nurseB->appointment == 'true') {
                return view('payment/doctor_success');
            }
            $notification = new \App\Libraries\Notification();
            $notification->sendMessage($nurseB->token, $user->registration_id, $nurseB->channel_id, ['first_name' => $customer->fname, 'last_name' => $customer->lname, 'call_type'=> $nurseB->call_type]);

            return view('payment/doctor_success');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }
    
    
    
        public function employeeFailed()
    {
        try {
            //die("Hello");
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 



            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            $orderResponse = json_decode($orderResponse);
            
            $data['payment_reference'] = $orderResponse->reference;
            $data['payment_status'] = 'cancelled';
            
            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse->reference])->first();
            
            if($o) {
                $order->update($o->id, $data);
            } 

            $nb = new \App\Models\Api\DoctorBooking();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            //var_dump($nurseB); die();
            if($nurseB) {
                $nbd['status'] = 'cancelled';
                $nb->update($nurseB->id, $nbd);
            }

            return view('payment/doctor_failed');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }

    public function doctorFailed()
    {
        try {
            //die("Hello");
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 



            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            $orderResponse = json_decode($orderResponse);
            
            $data['payment_reference'] = $orderResponse->reference;
            $data['payment_status'] = 'cancelled';
            
            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse->reference])->first();
            
            if($o) {
                $order->update($o->id, $data);
            } 

            $nb = new \App\Models\Api\DoctorBooking();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            //var_dump($nurseB); die();
            if($nurseB) {
                $nbd['status'] = 'cancelled';
                $nb->update($nurseB->id, $nbd);
            }

            return view('payment/doctor_failed');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }

    public function nurseSuccess()
    {
        try {
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token    = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse    = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            
            $orderResponse = json_decode($orderResponse);
            //dd(json_decode($orderResponse));
            //$data['payment_reference'] = $orderResponse['reference'];
            $data['payment_status'] = 'completed';
            $data['order_status'] = 'completed';

            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse->reference])->first();
            if($o) {
                $order->update($order->id, $data);
            }
            $nb = new \App\Models\Api\NurseBook();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            
            if($nurseB) {
                $nbd['status'] = 1;
                $nbd['booking_status'] = 'completed';
                $nb->update($nurseB->id, $nbd);
            
                $data['booking'] = $nurseB;
            }


            // Nurse Notification
            $nurseM = new \App\Models\Api\Nurse();
            $nurse = $nurseM->where(['id' => $nurseB->nurse_id])->first();
            
            $userM = new \App\Models\Api\User();
            $user = $userM->find($nurse->user_id);
            
            $customerM = new \App\Models\Api\Customer();
            $cust = $customerM->where(['id' => $nurseB->customer_id])->first();
            if(!$user) {
                // throw new Exception("Nurse not Found");
            }
            $notification = new \App\Libraries\Notification();
            $notification->sendNurseBookingMessage($user->registration_id, [
                'customer_first_name' => $cust->first_name . " " . $cust->last_name,
            ]);

            $cateM = new \App\Models\Api\Category();
            $cate = $cateM->where(['id' => $nurse->category])->first();

            $sms = new \App\Libraries\Sms();
            // Customer SMS
            $sms->caregiverCustomer([
                "phone" => $cust->mobile,
                'caregiver' => $cate->name,
                'nursename' => $nurse->first_name . " " . $nurse->last_name, 
                'from' => $nurseB->service_start_date, 
                'to' => $nurseB->service_end_date, 
                'bookingdate' => $nurseB->booking_date,
                'time' => $nurseB->service_time,
                'hour' => $nurseB->booked_for
            ]);

            //Nurse SMS
            $sms->caregiverNurse([
                "phone" => $nurse->phone,
                'caregiver' => $cate->name,
                'nursename' => $nurse->first_name . " " . $nurse->last_name, 
                'from' => $nurseB->service_start_date, 
                'to' => $nurseB->service_end_date, 
                'bookingdate' => $nurseB->booking_date,
                'time' => $nurseB->service_time,
                'hour' => $nurseB->booked_for,
                'address' => $cust->address
            ]);
        
            return view('payment/doctor_success');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }

    public function nurseFailed()
    {
        try {
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 



            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            $orderResponse = json_decode($orderResponse);
            $data['payment_reference'] = $orderResponse->reference;
 
            $data['payment_status'] = 'cancelled';
            $data['order_status'] = 'cancelled';
            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse->reference])->first();
            if($o) {
                $order->update($order->id, $data);
            }
            $nb = new \App\Models\Api\NurseBook();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            
            if($nurseB) {
                $nbd['status'] = 0;
                $nbd['booking_status'] = 'cancelled';
                $nb->update($nurseB->id, $nbd);
            
                $data['booking'] = $nurseB;
            }

            return view('payment/doctor_failed');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }


    public function requirementSuccess()
    {
        try {
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            //var_dump($tokenResponse); die();
            $access_token    = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse    = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            
            $orderResponse = json_decode($orderResponse);
            //dd(json_decode($orderResponse));
            //$data['payment_reference'] = $orderResponse['reference'];
            $data['payment_status'] = 'completed';

            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse->reference])->first();
            if($o) {
                $order->update($order->id, $data);
            }
            $nb = new \App\Models\Api\RequirementBook();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            
            if($nurseB) {
                $nbd['status'] = 'completed';
                $nb->update($nurseB->id, $nbd);
            
                $data['booking'] = $nurseB;
            }


            $requirementModel = new \App\Models\Api\Requirement();
            $req = $requirementModel->where(['id' => $nurseB->requirement_id])->first();
            //var_dump($req); die();
            if($req) {
                $rdata['status'] = 'completed';
                $requirementModel->update($req->id, $rdata);
            }
            
            $reqModel = new \App\Models\Api\Requirement();
            $req = $reqModel->where(['id' => $nurseB->requirement_id])->first();
            if($req) {
                $reqModel->update($req->id, [
                    'status' => 'completed'
                ]);
            }

            $custM = new \App\Models\Api\Customer();
            $cust  = $custM->where(['id' => $nurseB->customer_id])->first();

            $nurseM = new \App\Models\Api\Nurse();
            $nurse = $nurseM->where(['id' => $nurseB->nurse_id])->first();

            $cateM = new \App\Models\Api\Category();
            $cate = $cateM->where(['id' => $nurse->category])->first();


            $sms = new \App\Libraries\Sms();
            // Customer SMS
            $sms->babysittingCustomer([
                "phone" => $cust->mobile,
                'babysitter' => $cate->name,
                'nursename' => $nurse->first_name . " " . $nurse->last_name, 
                'from' => $req->start_date, 
                'to' => $req->end_date, 
                'bookingdate' => $nurseB->booking_date_time
            ]);

            //Nurse SMS
            $sms->babysittingNurse([
                "phone" => $nurse->phone,
                'babysitter' => $cate->name,
                'nursename' => $nurse->first_name . " " . $nurse->last_name, 
                'from' => $req->start_date, 
                'to' => $req->end_date, 
                'bookingdate' => $nurseB->booking_date_time,
                'area' => $req->area
            ]);
        
            return view('payment/doctor_success');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }

    public function requirementFailed()
    {
        try {
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            $orderResponse = json_decode($orderResponse);
            $data['payment_reference'] = $orderResponse->reference;

            // $data['status'] = 'failed';
            // $order = new \App\Models\Api\Order();
            // $o = $order->where(['order_id' => $orderResponse->reference])->first();
            // if($o) {
            //     $order->update($order->id, $data);
            // }
            //   Hello 

            $data['payment_status'] = 'cancelled';

            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse->reference])->first();
            if($o) {
                $order->update($order->id, $data);
            }
            $nb = new \App\Models\Api\RequirementBook();
            $nurseB = $nb->where(['order_id' => $o->id])->first();
            
            if($nurseB) {
                $nbd['status'] = 'cancelled';
                $nb->update($nurseB->id, $nbd);
            
                $data['booking'] = $nurseB;
            }

            
            

            return view('payment/doctor_failed');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }

    public function serviceSuccess()
    {
        try {
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 



            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
        
            $orderResponse = (array)json_decode($orderResponse);
            //var_dump($orderResponse['reference']); die();
            $data['payment_reference'] = $orderResponse['reference'];
            $data['payment_status'] = 'completed';

            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse['reference']])->first();
            if($o) {
                $order->update($o->id, $data);
            }

            $nb = new \App\Models\Api\ServiceBook();
            $nurseB = $nb->where(['order_id' => $o->id])->findAll();
            foreach($nurseB as $a) {
                if($a) {
                    $nbd['status'] = 'completed';
                    $nb->update($a->id, $nbd);
                }
            }

            $cartModel = new \App\Models\Api\Cart();
            $items = $cartModel->where(['customer_id' => $o->customer_id])->findAll();
            foreach($items as $i) {
                $cartModel->delete($i->id);
            }


            // $email = new \App\Libraries\Email();

            // $customer = new \App\Models\Customer();
            // $customer = $customer->where(['id' => $o->customer_id])->first();

            // $nurse = new \App\Models\Doctor();
            // $nurse = $nurse->where(['id' => $o->item_id])->first();
        
            // $setting = new \App\Models\Settings();
        
            // $data['item'] = $nurse;
            // $data['customer'] = $customer;
            // $data['order'] = $o;
            // $data['setting'] = $setting->first();

            // $cbody = view('templates/doctor_order_success', $data);
            // $nbody = view('templates/doctor_order_success', $data);
            // $ybody = view('templates/doctor_order_success', $data);
        
            // $email->sendMail($customer->email, 'Booking Summary', $cbody);

            // $email->sendMail($nurse->email, 'Booking Summary', $nbody);
            // $email->sendMail('admin@yesmaam.ae', 'Booking Summary', $ybody);
            
            
            return view('payment/doctor_success');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }
    }

    public function serviceFailed()
    {
        try {
            // Test Keys
            // $outletRef 	 	 = "57af269c-f285-4757-a6cc-9bc5451cc143";  
            // $apikey 		 = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";
            
            // Live Keys
            $outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384";  
            $apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

            $orderReference  = $_GET['ref']; 
            
            $idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
            $residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

            // $idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
            // $residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


            $tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse   = json_decode($tokenResponse);
            $access_token 	 = $tokenResponse->access_token;

            $responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            $orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
            $orderResponse = json_decode($orderResponse);
            $data['payment_reference'] = $orderResponse->reference;
            $data['payment_status'] = 'cancelled';

            $order = new \App\Models\Api\Order();
            $o = $order->where(['order_id' => $orderResponse->reference])->first();
            if($o) {
                $order->update($o->id, $data);
            }

            $nb = new \App\Models\Api\ServiceBook();
            $nurseB = $nb->where(['order_id' => $o->id])->findAll();
            foreach($nurseB as $a) {
                if($a) {
                    $nbd['status'] = 'cancelled';
                    $nb->update($a->id, $nbd);
                }
            }
            

            return view('payment/doctor_failed');
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        } 
    }
}