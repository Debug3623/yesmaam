<?php
namespace App\Controllers\Api;

use Exception;
use App\Models\Api\Order;
use App\Models\Api\Customer;
use App\Models\Api\ServiceBook;
use CodeIgniter\RESTful\ResourceController;

class CartController extends ResourceController
{
    protected $modelName = 'App\Models\Api\Cart';
    protected $returnType = 'json';

    public function all($id) {
        try {
            $model = new Customer();
            $customer = $model->where(['user_id' => $id])->first();
            if(!$customer) {
                throw new Exception("Customer not found");
            }

            $items = $this->model->getAllItems($customer->id);

            return $this->respond(['result' => $items]);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }
    }

    public function add() {
        try {
            $model = new Customer();
            $json = $this->request->getJSON();
            $customer = $model->where(['user_id' => $json->user_id])->first();
            if(!$customer) {
                throw new Exception("Customer not found");
            }

            $item = $this->model->where([
                'customer_id' => $customer->id, 
                'item_id' => $json->item_id,
                'item_type' => $json->item_type
            ])->first();

            if($item) {
                throw new Exception("Item already in your Cart");
            }
            
            $data['customer_id'] = $customer->id;
            $data['item_id'] = $json->item_id;
            $data['item_type'] = $json->item_type;
            $data['date_added'] = date('Y-m-d H:i:s');
            $data['quantity'] = $json->quantity;
            $data['rate'] = $json->rate;
            $data['status'] = 1;

            $this->model->insert($data);

            return $this->respond(['status' => 'success']);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }
    }

    public function remove($id) {
        try {
            $item = $this->model->where(['id' => $id])->first();
            if(!$item) {
                throw new Exception("Item not Found");
            }

            $this->model->delete($id);

            return $this->respond(['status' => 'success']);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }
    }

    public function empty($userId) {
        try {
            $model = new Customer();
            $customer = $model->where(['user_id' => $userId])->first();
            if(!$customer) {
                throw new Exception("Customer not found");
            }

            $items = $this->model->where(['customer_id' => $customer->id])->findAll();
            foreach($items as $item) {
                $this->model->delete($item->id);
            }

            return $this->respond(['status' => 'success']);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }
    }

    public function checkout() {
        try {
            $json = $this->request->getJSON();

            $customerModel = new Customer();
            $cust = $customerModel->where(['user_id' => $json->user_id])->first();
            if(!$cust) {
                throw new Exception("Customer not found");
            }

            $items = $this->model->where(['customer_id' => $cust->id])->findAll();
            if(!$items) {
                throw new Exception("Cart id Empty");
            }
            //var_dump($items); die();
            $serviceBook = new ServiceBook();
            $tot = 0; $id = '';
            foreach($items as $item) {
                $data['service_id'] = $item->item_id;
                $data['customer_id'] = $cust->id;
                $data['booking_date'] = date('Y-m-d');
                $data['status'] = 'process'; //'pending';
                $tot += $item->rate * $item->quantity;
                $id .= $item->id . ',';
            }

            $ids = str_replace(' ', ',', trim(str_replace(',', ' ', $id)));
            $odata['customer_id'] = $cust->id;
            $odata['amount'] = $tot;
            $odata['payment_type'] = 'online';
            $odata['order_date'] = $data['booking_date'];
            $odata['order_id'] = ''; 
            $odata['order_for'] = 'service';
            $odata['item_ids'] = $ids;
            $odata['payment_id'] = '';
            $odata['billing_firstname'] = $json->billing_firstname;
            $odata['billing_lastname'] = $json->billing_lastname;
            $odata['billing_email'] = $json->billing_email;
            $odata['billing_address'] = $json->billing_address;
            $odata['billing_city'] = $json->billing_city;
            $odata['billing_country_code'] = $json->billing_country_code;
            $odata['payment_status'] = 'pending';

            $d = $this->CardPayment($odata);
            //var_dump($d); die();
            $order = new Order();
            $odata['order_id'] = $d['order_reference'];
            $oid = $order->insert($odata);


            foreach($items as $item) {
                $data['service_id'] = $item->item_id;
                $data['customer_id'] = $cust->id;
                $data['booking_date'] = date('Y-m-d');
                $data['status'] = 'pending';
                $data['order_id'] = $oid;
                $serviceBook->insert($data);
            }
            

            return $this->respond([
                'redirect_link' => $d['paymentLink'],
                'booking_id' => $ids
            ]);
            
            
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
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
    public function CardPayment($data)
    {
        try {


	        set_time_limit(0);
            // Test Keys
	        // $outletRef       ="57af269c-f285-4757-a6cc-9bc5451cc143"; //  
	        // $apikey          = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";

            // Live Keys
            $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384";
	        $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";


	        // Test URLS 
	    //    $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
	    //    $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        // LIVE URLS 
	        $idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
	        $txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        $tokenHeaders  = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
	        $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
	        $tokenResponse = json_decode($tokenResponse);
    //dd($tokenResponse);

	        $access_token  = $tokenResponse->access_token;
	        

	        $order = array();   

	        $order['action'] = "SALE"; // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
	        $order['amount']['currencyCode'] = "AED"; // Payment currency ('AED' only for now)
	        $order['amount']['value']             = $data['amount'] * 100;                                   // Minor units (1000 = 10.00 AED)
	        $order['language']                    = "en";                           // Payment page language ('en' or 'ar' only)
	        $order['emailAddress']                = $data['billing_email'];      
	        $order['billingAddress']['firstName'] = $data['billing_firstname'];      
	        $order['billingAddress']['lastName']  = $data['billing_lastname'];      
	        $order['billingAddress']['address1']  = $data['billing_address'];      
	        $order['billingAddress']['city']      = $data['billing_city'];      
	        $order['billingAddress']['countryCode'] = "USA";      
	                                          
	        $order['merchantOrderReference'] = time();
	        $order['merchantAttributes']['redirectUrl'] = site_url('api/payment/service/success'); //site_url('payment/doctor/success')
	        $order['merchantAttributes']['skipConfirmationPage'] = true;
	        $order['merchantAttributes']['cancelUrl']   = site_url('api/payment/service/fail'); //site_url('payment/doctor/failed')
	        $order['merchantAttributes']['cancelText']  = 'Cancel';
	        //dd($order);
	        $order = json_encode($order);  

	        $orderCreateHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
	        //$orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
	        $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
	        //dd($orderCreateResponse);

	        $orderCreateResponse = json_decode($orderCreateResponse);
	        //var_dump($orderCreateResponse); die();

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