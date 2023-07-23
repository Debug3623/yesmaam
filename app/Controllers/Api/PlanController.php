<?php

namespace App\Controllers\Api;

use Exception;
use App\Models;
use App\Models\Api\Nurse;
use App\Models\Api\User;
use App\Models\Api\Order;
use App\Libraries\Email;
use App\Models\Api\Customer;
use App\Models\Api\PurchasePlan;
use App\Models\Api\Plan;
use App\Models\Api\Insurance;
use App\Models\Api\Settings;
use App\Models\Api\CoporateUser;
use App\Models\Api\Document;
use App\Models\Api\EmailVerification;
use CodeIgniter\RESTful\ResourceController;

class PlanController extends ResourceController
{
     protected $modelName = 'App\Models\Api\Plan';

    protected $format = 'json';



    public function allNurseCategories()

    {

        try {

            $data = $this->model->where([

                'cate_for' => 'nurse'

            ])->findAll();

            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }



    public function allDoctorCategories()

    {

        try {

            $data = $this->model->where([

                'cate_for' => 'doctor'

            ])->findAll();

            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }

    

    public function allPlans()

    {

        try {

            $data = $this->model->findAll();

            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }
    
       public function getAllInsurance()

    {

        try {
            
            
            
            $user = new \App\Models\Api\Insurance();

            $data = $user->findAll();

            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }
    
    
    

    public function getBabySitterCategories()
    {
        try {
            $cate = $this->model->where([
                'cate_for' => 'babysitter'
            ])->findAll();
            return $this->respond([
                'result' => $cate
            ]);
        } 
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error', 'msg' => $e->getMessage()
            ]);
        }
    }
    
    
    public function categoryWiseDoctor()

    {

        try {
            
            $category_id = $this->request->getPost('category');

             $user = new \App\Models\Api\Doctor();
            $data = $user->where(['category' => $category_id])->findAll();

            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }
    
      public function userPlans()

    {

        try {
            
            $user_id = $this->request->getPost('user_id');

            $plan = new \App\Models\Api\PurchasePlan();
            
             $data= $plan->distinct()->
             select('purchase_plans.id,purchase_plans.employee,purchase_plans.physio_doctor,
             purchase_plans.medical_camp,purchase_plans.total_price,purchase_plans.start_date as purchased_date,purchase_plans.payment_status,
             users.name as username,plans.title,plans.description,plans.package_price as basic_price,plans.symbol')
              
                ->where('purchase_plans.user_id',$user_id)
                ->join('plans','plans.id=purchase_plans.plan_id')
                ->join('users','users.id=purchase_plans.user_id')
                ->orderBy('purchase_plans.id','DESC')
                ->Limit(1)
                ->first();
        
            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }
    
    
        
      public function corporateUserPlans()

    {

        try {
            
            $user_id = $this->request->getPost('user_id');

            $plan = new \App\Models\Api\PurchasePlan();
            
             $data= $plan->distinct()->
             select('purchase_plans.id,purchase_plans.employee,purchase_plans.physio_doctor,
             purchase_plans.medical_camp,purchase_plans.total_price,purchase_plans.start_date as purchased_date,
             users.name as username,plans.title,plans.description,plans.package_price as basic_price,plans.symbol')
              
                ->where('purchase_plans.user_id',$user_id)
                 ->where('purchase_plans.status',1)
                ->join('plans','plans.id=purchase_plans.plan_id')
                ->join('users','users.id=purchase_plans.user_id')
                ->findAll();
            
            

            return $this->respond(['status' => 200, 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 401, 'msg' => $e->getMessage()]);

        }

    }
    
     public function buyPlan()

       {

        try {
                $date=date('Y-m-d');
            	$umodel = new \App\Models\Api\PurchasePlan();
				$udata['plan_id'] = $this->request->getPost('plan_id');
				$udata['user_id'] = $this->request->getPost('user_id');
				$udata['physio_doctor'] = $this->request->getPost('physio_doctor');
				$udata['medical_camp'] = $this->request->getPost('medical_camp');
				$udata['employee'] = $this->request->getPost('employee');
				$udata['total_price'] = $this->request->getPost('total_price');
				
				$udata['start_date'] = $date;
				
				
                $plan = new \App\Models\Api\Plan();
            
                $data = $plan->where(['id' => $udata['plan_id']])->first();

				   //var_dump($data);die();
                
                if($data->title == "1-Month Subscription Plan")
                {

                $newDate = date('Y-m-d', strtotime($date. ' + 30 days'));
                $udata['end_date'] = $newDate;

                }elseif($data->title =="3 Days Free")
                {
                 
                 $newDate = date('Y-m-d', strtotime($date. ' + 3 days'));
                $udata['end_date'] = $newDate;
                }
                elseif($data->title == "3-Month Subscription Plan")
                {
                    
                $newDate = date('Y-m-d', strtotime($date. ' + 90 days'));
                $udata['end_date'] = $newDate;

                }
                elseif($data->title == "6-Month Subscription Plan")
                {
                    
                $newDate = date('Y-m-d', strtotime($date. ' + 182 days'));
                $udata['end_date'] = $newDate;


                }
                elseif($data=="12-Month Subscription Plan")
                {
                   
                 $newDate = date('Y-m-d', strtotime($purchased_date. ' + 365 days'));
                 $udata['end_date'] = $newDate;

                }

				$data = $umodel->insert($udata);
				
				return $this->respond(['status' =>200 ,'message'=> 'Plan Purchased Successfully']);

				
        }
        
        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }
    }
    
         public function buyPlanCorporate()
    {
        try {
            //throw new Exception("Error ABC");
            $json = $this->request->getJSON();
            //echo($json->booking->user_id); die();

            $model = new  CoporateUser();
            //$booking = new \App\Models\Api\DoctorBooking();

            $customer = $model->where([
                'user_id' => $json->user_id
            ])->first();
            
    

            if(!$customer) {
                throw new Exception("User not found");
            }

                $plan = new \App\Models\Api\Plan();
            
                $planss = $plan->where(['id' => $json->plan_id])->first();

            $odata['user_id'] = $customer->user_id;
            $odata['amount'] = $json->total_price;
            $odata['payment_type'] = "Plan Payment";
            $odata['order_date'] = date('Y-m-d H:i:s', time());
            $odata['order_id'] = 'YMDO' . date('ymd') . uniqid();
            $odata['order_for'] = 'corporate';
            $odata['payment_id'] = '';
            $odata['payment_status'] = 'Pending';
            $odata['order_status'] = 'progress';

                $odata['billing_firstname'] = $customer->first_name;
                $odata['billing_lastname'] = $customer->last_name;
                $odata['billing_email'] = "mjawadsagheer@gmail.com";
                $odata['billing_address'] = $customer->company_address;
                $odata['billing_city'] = $customer->city;
                $odata['billing_country_code'] = 'AED';
                
                
                //var_dump($odata);die();

                $d = $this->purchasePlanCardPayment($odata);
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
                  $date=date('Y-m-d');
            	$umodel = new \App\Models\Api\PurchasePlan();
				$udata['plan_id'] = $json->plan_id;
				$udata['user_id'] = $json->user_id;
				$udata['physio_doctor'] = $json->physio_doctor;
				$udata['medical_camp'] = $json->medical_camp;
				$udata['employee'] = $json->employee;
				$udata['total_price'] = $json->total_price;
			    $udata['order_id'] =$id;
				$udata['start_date'] = $date;
				
				
                $plan = new \App\Models\Api\Plan();
            
                $data = $plan->where(['id' => $json->plan_id])->first();

				  // var_dump($data);die();
                
                if($data->title == "1-Month Subscription Plan")
                {

                $newDate = date('Y-m-d', strtotime($date. ' + 30 days'));
                $udata['end_date'] = $newDate;

                }elseif($data->title =="3 Days Free")
                {
                 
                 $newDate = date('Y-m-d', strtotime($date. ' + 3 days'));
                $udata['end_date'] = $newDate;
                }
                elseif($data->title == "3-Month Subscription Plan")
                {
                    
                $newDate = date('Y-m-d', strtotime($date. ' + 90 days'));
                $udata['end_date'] = $newDate;

                }
                elseif($data->title == "6-Month Subscription Plan")
                {
                    
                $newDate = date('Y-m-d', strtotime($date. ' + 182 days'));
                $udata['end_date'] = $newDate;


                }
                elseif($data=="12-Month Subscription Plan")
                {
                   
                 $newDate = date('Y-m-d', strtotime($purchased_date. ' + 365 days'));
                 $udata['end_date'] = $newDate;

                }
                
                //var_dump($udata);die();

				$data = $umodel->insert($udata);
                return $this->respond([
                    'status'=>200,
                    'message'=>"Successfully plan purchased",
                    'redirect_link' => $d['paymentLink'],
                    'id' => $data
                    
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
    
    
       public function purchasePlanCardPayment($data)
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
	        $order['merchantAttributes']['redirectUrl'] = site_url('api/payment/plan/success'); //site_url('payment/doctor/success')
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
         public function remainingDays()

       {

        try {
             $user_id = $this->request->getPost('user_id');

            $plan = new \App\Models\Api\PurchasePlan();
            
             $data= $plan->distinct()->
             select('purchase_plans.id,purchase_plans.employee,purchase_plans.physio_doctor,
             purchase_plans.medical_camp,purchase_plans.total_price,purchase_plans.start_date as purchased_date,purchase_plans.end_date,
             users.name as username,plans.title,plans.description,plans.package_price as basic_price,plans.symbol')
              
                ->where('purchase_plans.user_id',$user_id)
                 ->where('purchase_plans.status',1)
                ->join('plans','plans.id=purchase_plans.plan_id')
                ->join('users','users.id=purchase_plans.user_id')
                ->findAll();
                

                foreach($data as $value){
                $totaldate=$value->title;
                $purchased_date=$value->purchased_date;
                $end_date=$value->end_date;
                }
       
    
                $date1=date_create($purchased_date);
                $date2=date_create($end_date);
                $diff=date_diff($date1,$date2);
                $day= $diff->format("%a");
    
				
				return $this->respond(['status' =>200 ,'message'=> 'Remaining days','data'=>$day]);

				
        }
        
        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }
    }
				
}