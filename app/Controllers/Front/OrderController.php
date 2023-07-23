<?php
namespace App\Controllers\Front;

use App\Models\Order;
use App\Models\Nurse;
use App\Models\Customer;
use App\Models\Settings;
use App\Libraries\Email;
use App\Models\NurseBook;

class OrderController extends \App\Controllers\BaseController
{
	public function summary()
	{
		//dd("Hello");
		/*
		$odata['customer_id'] = $customer_id;
		$odata['amount'] = $bdata['total_amount'];
		$odata['payment_type'] = 'Online';
		$odata['order_date'] = date('Y-m-d H:i:s');
		$odata['order_id'] = 'YMO' . date('y') . date('m') . date('d') . uniqid();
		$odata['order_for'] = 'nurse';
		$odata['item_id'] = $nurse_id;
		$odata['payment_id'] = '';
		$odata['payment_status'] = 'pending';
		$order = new Order();
		$order->insert($odata);
		*/
		$data['booking'] = session()->get('booking');
		$data['msg'] = session()->getFlashdata('msg');
		$data['errmsg'] = '';
		
		$nurse = new Nurse();
		$data['item'] = $nurse->where(['id' => $data['booking']['nurse_id']])->first();

		$nurse = new Customer();
		$data['customer'] = $nurse->where(['id' => $data['booking']['customer_id']])->first();

		$set = new Settings();
		$data['setting'] = $set->first();

		helper('form');


		//dd($data);
		if($this->request->getMethod() == 'post') {
			$rules = [
				'firstName' => [
					'label' => 'First Name',
					'rules' => 'trim|required'
				],
				'lastName' => [
					'label' => 'Last Name',
					'rules' => 'trim|required'
				],
				'email' => [
					'label' => 'Email Address',
					'rules' => 'trim|required'
				],
				'address' => [
					'label' => 'Address',
					'rules' => 'trim|required'
				],
				'city' => [
					'label' => 'City',
					'rules' => 'trim|required'
				],
				'payment_method' => [
					'label' => 'Payment Method',
					'rules' => 'trim|required'
				],
              	'special_instruction' => [
					'label' => 'Special Instructions',
					'rules' => 'trim'
				],
			];

			if($this->validate($rules)) {
				$data['customer_id'] = $data['customer']->id;
				$data['amount'] = $data['booking']['total_amount'];
				$data['payment_type'] = $this->request->getPost('payment_method');
				$data['order_date'] = date('Y-m-d H:i:s', time());
				$data['order_id'] = 'YMNO' . date('ymd') . uniqid();
				$data['order_for'] = 'nurse';
				$data['item_id'] = $data['item']->id;
				$data['payment_id'] = '';
				$data['payment_status'] = 'Pending';
				$data['billing_firstname'] = $this->request->getPost('firstName');
				$data['billing_lastname'] = $this->request->getPost('lastName');
				$data['billing_email'] = $this->request->getPost('email');
				$data['billing_address'] = $this->request->getPost('address');
				$data['billing_city'] = $this->request->getPost('city');
				$data['billing_country_code'] = 'USA';
				//dd($data);

				if($this->request->getPost('payment_method') == 'cod') {
					
					$body = view('templates/nurse/cod', $data);
					$body2 = view('templates/nurse/nurse_cod', $data);
					$body3 = view('templates/nurse/admin_cod', $data);
					//return $body3;

					$nurse = new \App\Models\Nurse();
					$nurse = $nurse->where(['id' => $data['item_id']])->first();


					$email = new Email();
					
					$email->sendMail($data['customer']->email, 'Booking Summary', $body);

					$email->sendMail($nurse->email, 'Booking Summary', $body2);
					$email->sendMail('admin@yesmaam.ae', 'Booking Summary', $body3);
					
					//die();

					$order = new Order();
					$oid = $order->insert($data);
					
                  	$data['booking']['special_instruction'] = $this->request->getPost('special_instruction');
					$data['booking']['order_id'] = $oid;
					$data['booking']['status'] = 1;
					$data['booking']['booking_date'] = date('Y-m-d');

					$nb = new NurseBook();
					$nb->insert($data['booking']);

					return view('orders/cod_success');
				}
				else if($this->request->getPost('payment_method') == 'card') {
					$d = $this->CardPayment($data);

					$order = new Order();
					$data['order_id'] = $d['order_reference'];
					$id = $order->insert($data);

					$nb = new NurseBook();
					$data['booking']['status'] = 0;
					$data['booking']['order_id'] = $id;
                  	$data['booking']['special_instruction'] = $this->request->getPost('special_instruction');
					$nb->insert($data['booking']);

					return redirect()->to($d['paymentLink']);
				}
			}
			else {
				$data['validator'] = $this->validator;
				return view('orders/summary', $data);
			}
		}
		else {
			return view('orders/summary', $data);
		}
	}

	public function CardPayment($data)
    {
        try {


	        set_time_limit(0);
	        $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"57af269c-f285-4757-a6cc-9bc5451cc143";  
	        $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ=="; //"YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";


	        // Test URLS 
	        //$idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
	        //$txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        // LIVE URLS 
	        $idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
	        $txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        $tokenHeaders  = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
	        $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
	        $tokenResponse = json_decode($tokenResponse);


	        $access_token  = $tokenResponse->access_token;
	        //dd($access_token);

	        $order = array();   

	        $order['action']                      = "AUTH"; //"SALE";                         // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
	        $order['amount']['currencyCode']      = "AED";                           // Payment currency ('AED' only for now)
	        $order['amount']['value']             = $data['amount'] * 100;                                   // Minor units (1000 = 10.00 AED)
	        $order['language']                    = "en";                           // Payment page language ('en' or 'ar' only)
	        $order['emailAddress']                = $data['billing_email'];      
	        $order['billingAddress']['firstName'] = $data['billing_firstname'];      
	        $order['billingAddress']['lastName']  = $data['billing_lastname'];      
	        $order['billingAddress']['address1']  = $data['billing_address'];      
	        $order['billingAddress']['city']      = $data['billing_city'];      
	        $order['billingAddress']['countryCode'] = "AED";      
	                                          
	        $order['merchantOrderReference'] = time();
	        $order['merchantAttributes']['redirectUrl'] = site_url('payment/success'); //'http://127.0.0.1:8080/payment'; //;
	        $order['merchantAttributes']['skipConfirmationPage'] = true;
	        $order['merchantAttributes']['cancelUrl']   = site_url('payment/failed'); //'http://127.0.0.1:8080/payment';//
	        $order['merchantAttributes']['cancelText']  = 'Cancel';
	        //dd($order);
	        $order = json_encode($order);  

	        $orderCreateHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
	        //$orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
	        $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
	        //dd($orderCreateResponse);

	        $orderCreateResponse = json_decode($orderCreateResponse);
			//dd($orderCreateResponse);

	        $d['paymentLink'] = $orderCreateResponse->_links->payment->href; 
	        $d['order_reference'] = $orderCreateResponse->reference;
	        return $d;

    	}
    	catch(\Exception $e) {
    		die("Error: " . $e->getMessage());
    	}
        //return header("Location: ".$paymentLink); 

    }

    function invokeCurlRequest($type, $url, $headers, $post) {
            
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     

        if ($type == "POST") {
        
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        
        }

        $server_output = curl_exec ($ch);
        curl_close ($ch);
        
        return $server_output;
        
    }   
  
  
  
  	public function success()
    {
    	return view("orders/success");
    }
  
  	public function Doctorsummary()
	{
		/*
		$odata['customer_id'] = $customer_id;
		$odata['amount'] = $bdata['total_amount'];
		$odata['payment_type'] = 'Online';
		$odata['order_date'] = date('Y-m-d H:i:s');
		$odata['order_id'] = 'YMO' . date('y') . date('m') . date('d') . uniqid();
		$odata['order_for'] = 'nurse';
		$odata['item_id'] = $nurse_id;
		$odata['payment_id'] = '';
		$odata['payment_status'] = 'pending';
		$order = new Order();
		$order->insert($odata);
		*/
		$data['booking'] = session()->get('dbooking');

		//dd($data['booking']);
		$data['msg'] = session()->getFlashdata('msg');
		$data['errmsg'] = '';
		
		$doctor = new \App\Models\Doctor();
		$data['item'] = $doctor->where(['id' => $data['booking']['doctor_id']])->first();

		$customer = new Customer();
		$data['customer'] = $customer->where(['id' => $data['booking']['customer_id']])->first();

		$set = new Settings();
		$data['setting'] = $set->first();
		$data['booking']['total_amount'] = $data['setting']->doctor_hour_rate;

		helper('form');


		//dd($data);
		if($this->request->getMethod() == 'post') {
			$rules = [
				'firstName' => [
					'label' => 'First Name',
					'rules' => 'trim|required'
				],
				'lastName' => [
					'label' => 'Last Name',
					'rules' => 'trim|required'
				],
				'email' => [
					'label' => 'Email Address',
					'rules' => 'trim|required'
				],
				'address' => [
					'label' => 'Address',
					'rules' => 'trim|required'
				],
				'city' => [
					'label' => 'City',
					'rules' => 'trim|required'
				],
				'emirates_id' => [
					'label' => 'Emirates ID',
					'rules' => 'trim'
				],
				'insurance_no' => [
					'label' => 'Insurance No',
					'rules' => 'trim'
				],
				
			];

			if($this->validate($rules)) {
				$data['customer_id'] = $data['customer']->id;
				$data['amount'] = $data['setting']->doctor_hour_rate;
				$data['payment_type'] = $this->request->getPost('payment_method');
				$data['order_date'] = date('Y-m-d H:i:s', time());
				$data['order_id'] = 'YMDO' . date('ymd') . uniqid();
				//$data['order_for'] = 'nurse';
				$data['item_id'] = $data['item']->id;
				$data['payment_id'] = '';
				$data['payment_status'] = 'Pending';
				$data['billing_firstname'] = $this->request->getPost('firstName');
				$data['billing_lastname'] = $this->request->getPost('lastName');
				$data['billing_email'] = $this->request->getPost('email');
				$data['billing_address'] = $this->request->getPost('address');
				$data['billing_city'] = $this->request->getPost('city');
				$data['billing_country_code'] = 'USA';
				//dd($this->request->getPost('insurance_no'));

				if($this->request->getPost('insurance_no')) {

					$order = new Order();
					$oid = $order->insert($data);
					
                  	

					$data['booking']['insurance_no'] = $this->request->getPost('insurance_no');
					$data['booking']['emirates_id'] = $this->request->getPost('emirates_id');
					$data['booking']['order_id'] = $oid;
					$nb = new \App\Models\DoctorBooking();
					$nb->insert($data['booking']);
					//dd($data['booking']);
					$o['booking'] = $data['booking'];
					$o['setting'] = $data['setting'];
					$o['customer'] = $data['customer'];
                  

					$doc = new \App\Models\Doctor();
					$o['item'] = $doc->where(['id' => $data['item']->id])->first();

					$o['order'] = $data;
					$body = view('templates/doctor/customer', $o);
					$body2 = view('templates/doctor/doctor', $o);
					$body3 = view('templates/doctor/admin', $o);

					
					//return $body;
					$email = new Email();
					
					$email->sendMail($data['customer']->email, 'Booking Summary', $body);
					$email->sendMail($o['item']->email, 'Booking Summary', $body2);
					$email->sendMail('admin@yesmaam.ae', 'Booking Summary', $body2);
                    //dd((object)$o['item']);
                    return view('orders/cod_success');
				}
				else {
					//dd("No Insurance");
					$d = $this->DoctorCardPayment($data);
					$order = new Order();
					$data['order_id'] = $d['order_reference'];
					//dd($data['order_id']);
					$id = $order->insert($data);

					$nb = new \App\Models\DoctorBooking();
					$data['booking']['status'] = 0;
					$data['booking']['order_id'] = $id;
					$data['total_amount'] = $data['setting']->doctor_hour_rate;
					$nb->insert($data['booking']);

					return redirect()->to($d['paymentLink']);
				}
			}
			else {
				$data['validator'] = $this->validator;
				return view('orders/doctor_summary', $data);
			}
		}
		else {
			return view('orders/doctor_summary', $data);
		}
	}

	public function DoctorCardPayment($data)
    {
        try {


	        set_time_limit(0);
	        $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"57af269c-f285-4757-a6cc-9bc5451cc143";  
	        $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ=="; //"YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";


	        // Test URLS 
	        //$idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
	        //$txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        // LIVE URLS 
	        $idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
	        $txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        $tokenHeaders  = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
	        $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
	        $tokenResponse = json_decode($tokenResponse);


	        $access_token  = $tokenResponse->access_token;
	        //dd(site_url('/payment'));

	        $order = array();   

	        $order['action']                      = "SALE";                                        // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
	        $order['amount']['currencyCode']      = "AED";                           // Payment currency ('AED' only for now)
	        $order['amount']['value']             = $data['amount'] * 100;                                   // Minor units (1000 = 10.00 AED)
	        $order['language']                    = "en";                           // Payment page language ('en' or 'ar' only)
	        $order['emailAddress']                = $data['billing_email'];      
	        $order['billingAddress']['firstName'] = $data['billing_firstname'];      
	        $order['billingAddress']['lastName']  = $data['billing_lastname'];      
	        $order['billingAddress']['address1']  = $data['billing_address'];      
	        $order['billingAddress']['city']      = $data['billing_city'];      
	        $order['billingAddress']['countryCode'] = "USA";      
	                                          
	        $order['merchantOrderReference'] = time();
	        $order['merchantAttributes']['redirectUrl'] = site_url('payment/doctor/success'); //site_url('payment/doctor/success')
	        $order['merchantAttributes']['skipConfirmationPage'] = true;
	        $order['merchantAttributes']['cancelUrl']   = site_url('payment/doctor/failed'); //site_url('payment/doctor/failed')
	        $order['merchantAttributes']['cancelText']  = 'Cancel';
	        //dd($order);
	        $order = json_encode($order);  

	        $orderCreateHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
	        //$orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
	        $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
	        //dd($orderCreateResponse);

	        $orderCreateResponse = json_decode($orderCreateResponse);
	        //dd($orderCreateResponse);

	        $d['paymentLink'] = $orderCreateResponse->_links->payment->href; 
	        $d['order_reference'] = $orderCreateResponse->reference;
	        return $d;

    	}
    	catch(\Exception $e) {
    		die("Error: " . $e->getMessage());
    	}
        //return header("Location: ".$paymentLink); 

    }
}