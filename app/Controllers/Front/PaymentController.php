<?php
namespace App\Controllers\Front;

use App\Models\Order;
use App\Models\NurseBook;
use App\Models\DoctorBooking;

class PaymentController extends \App\Controllers\BaseController
{
	public function paymentSuccessful()
	{
		//die("Success");
      	$outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"57af269c-f285-4757-a6cc-9bc5451cc143";  
		$apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ=="; //"YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";

		$orderReference  = $_GET['ref']; 
		//$orderReference  = 'd4008299-a923-4fde-9107-e0af33114549'; 
		$idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
		$residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

		//$idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
		//$residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


		$tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
		$tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
		$tokenResponse   = json_decode($tokenResponse);
		$access_token 	 = $tokenResponse->access_token;

		$responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
		$orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
		
      	$orderResponse = json_decode($orderResponse);
      	//dd(json_decode($orderResponse));
		//$data['payment_reference'] = $orderResponse['reference'];
		$data['payment_status'] = 'completed';

		$order = new Order();
		$o = $order->where(['order_id' => $orderResponse->reference])->first();
		if($o) {
			$order->update($order->id, $data);
		}
      	$nb = new \App\Models\NurseBook();
		$nurseB = $nb->where(['order_id' => $o->id])->first();
      	
		if($nurseB) {
			$nbd['status'] = 1;
			$nb->update($nurseB->id, $nbd);
          
          	$data['booking'] = $nurseB;
		}
      
      	
		

		$email = new \App\Libraries\Email();

		$customer = new \App\Models\Customer();
		$customer = $customer->where(['id' => $o->customer_id])->first();

		$nurse = new \App\Models\Nurse();
		$nurse = $nurse->where(['id' => $o->item_id])->first();
      
      	$setting = new \App\Models\Settings();
      
      	
		
      	$data['item'] = $nurse;
      	$data['customer'] = $customer;
      	$data['order'] = $o;
      	$data['setting'] = $setting->first();
      	//echo '<pre>';
      	//var_dump($data['order']); die();
      	
		//$body = view('templates/order_confirmation', $data);
		//$body2 = view('templates/nurse_order', $data);
      	$body = view('templates/nurse/card', $data);
      	$body2 = view('templates/nurse/nurse_card', $data);
      	$body3 = view('templates/nurse/admin_card', $data);
      	//var_dump($data); die();
		$email->sendMail($customer->email, 'Booking Summary', $body);

		$email->sendMail($nurse->email, 'Booking Summary', $body2);
		$email->sendMail('admin@yesmaam.ae', 'Booking Summary', $body3);

		return redirect()->to('order/success');
	}

	public function paymentFailed()
	{
		$outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"57af269c-f285-4757-a6cc-9bc5451cc143";  
		$apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ=="; //"YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";

		$orderReference  = $_GET['ref']; 
		//$orderReference  = 'd4008299-a923-4fde-9107-e0af33114549'; 
		$idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
		$residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

		//$idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
		//$residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


		$tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
		$tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
      	//dd($tokenResponse);
		$tokenResponse   = json_decode($tokenResponse);
		$access_token 	 = $tokenResponse->access_token;
		//dd($access_token);
		$responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
		$orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
		$orderResponse = json_decode($orderResponse);
		$data['payment_reference'] = $orderResponse->reference;
      	return view('orders/failed');
		//dd("Failed");
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
  
  	public function doctorPaymentSuccessful()
	{
		
		$outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"57af269c-f285-4757-a6cc-9bc5451cc143";  
		$apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ=="; //"YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";

		$orderReference  = $_GET['ref']; 
		//$orderReference  = 'd4008299-a923-4fde-9107-e0af33114549'; 
		$idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
		$residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

		//$idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
		//$residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


		$tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
		$tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
		$tokenResponse   = json_decode($tokenResponse);
		$access_token 	 = $tokenResponse->access_token;

		$responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
		$orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
    
    	$orderResponse = (array)json_decode($orderResponse);
		//dd($orderResponse);
		//$data['payment_reference'] = $orderResponse['reference'];
		$data['payment_status'] = 'completed';

		$order = new Order();
		$o = $order->where(['order_id' => $orderResponse['reference']])->first();
		if($o) {
			$order->update($order->id, $data);
		}

		$nb = new \App\Models\DoctorBooking();
		$nurseB = $nb->where(['order_id' => $o->id])->first();
		if($nurseB) {
			$nbd['status'] = 1;
			$nb->update($nurseB->id, $nbd);
		}


		$email = new \App\Libraries\Email();

		$customer = new \App\Models\Customer();
		$customer = $customer->where(['id' => $o->customer_id])->first();

		$nurse = new \App\Models\Doctor();
		$nurse = $nurse->where(['id' => $o->item_id])->first();
    
    	$setting = new \App\Models\Settings();
    
    	$data['item'] = $nurse;
      	$data['customer'] = $customer;
      	$data['order'] = $o;
      	$data['setting'] = $setting->first();

		$cbody = view('templates/doctor_order_success', $data);
		$nbody = view('templates/doctor_order_success', $data);
		$ybody = view('templates/doctor_order_success', $data);
    
		$email->sendMail($customer->email, 'Booking Summary', $cbody);

		$email->sendMail($nurse->email, 'Booking Summary', $nbody);
		$email->sendMail('admin@yesmaam.ae', 'Booking Summary', $ybody);
		

		return redirect('order/success');
	}

	public function doctorPaymentFailed()
	{
		$outletRef 	 	 = "3024a0f5-a490-47dd-99ce-2e92ce322384"; //"57af269c-f285-4757-a6cc-9bc5451cc143";  
		$apikey 		 = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ=="; //"YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";

		$orderReference  = $_GET['ref']; 
		//$orderReference  = 'd4008299-a923-4fde-9107-e0af33114549'; 
		$idServiceURL    = "https://identity.ngenius-payments.com/auth/realms/Networkinternational/protocol/openid-connect/token";           // set the identity service URL (example only)
		$residServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 

		//$idServiceURL    = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
		//$residServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders/".$orderReference; 


		$tokenHeaders    = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
		$tokenResponse   = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
		$tokenResponse   = json_decode($tokenResponse);
		$access_token 	 = $tokenResponse->access_token;

		$responseHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
		$orderResponse 	  = $this->invokeCurlRequest("GET", $residServiceURL, $responseHeaders, '');
		$orderResponse = json_decode($orderResponse);
		$data['payment_reference'] = $orderResponse->reference;
		return view('orders/failed');
	}
}