<?php
namespace App\Controllers\Api;

use Exception;
use App\Models\Api\Order;
use App\Models\Api\Settings;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;


class NurseBookingController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Api\NurseBook';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        try { 
            $json = $this->request->getJSON();
            $customer = new \App\Models\Api\Customer();
            $cust = $customer->where([
                'user_id' => $json->user_id
            ])->first();
            
            if(!$cust) {
                throw new Exception("Customer not Found");
            }

            $nurseM = new \App\Models\Api\Nurse();
            $nurse = $nurseM->where([
                'id' => $json->nurse_id
            ])->first();
            if(!$nurse) {
                throw new Exception("Nurse not Found");
            }

            $cateM = new \App\Models\Api\Category();
            $cate = $cateM->where([
                'id' => $nurse->category
            ])->first();

            $setting = new Settings();
            $setting = $setting->first();

            $data['customer_id'] = $cust->id;
            $data['nurse_id'] = $json->nurse_id;
            $data['service_start_date'] = $json->service_start_date;
            $data['service_end_date'] = $json->service_end_date;
            $data['service_time'] = $json->service_time;
            $data['booked_for'] = $json->booking_hours;
            $data['booking_date'] = date('Y-m-d');
            $data['booking_status'] = 'pending';
            //var_dump($data); die();
            $now = strtotime($json->service_end_date); // or your date as well
            $your_date = strtotime($json->service_start_date);
            $datediff = $now - $your_date;
            $days = 1 + round($datediff / (60 * 60 * 24));
            
            if($cate->cate_for == 'babysitter') {
                $rate = $setting->babysitter_rate;
            }
            else {
                $rate = $setting->nurse_hour_rate;
            }
            $data['total_amount'] = $rate * $json->booking_hours;
            //var_dump($data); die();
            $odata['customer_id'] = $cust->id;
            $odata['amount'] = $data['total_amount'];
            $odata['payment_type'] = $json->payment_type;
            $odata['order_date'] = date('Y-m-d');
            $odata['order_id'] = 'YMNO' . date('ymd') . uniqid();
            $odata['order_for'] = 'nurse';
            $odata['item_id'] = $json->nurse_id;
            $odata['payment_id'] = '';
            $odata['billing_firstname'] = $json->billing_firstname;
            $odata['billing_lastname'] = $json->billing_lastname;
            $odata['billing_email'] = $json->billing_email;
            $odata['billing_address'] = $json->billing_address;
            $odata['billing_city'] = $json->billing_city;
            $odata['billing_country_code'] = 'UAE';
            $odata['payment_status'] = "pending";
            //var_dump($odata); die();
            
            
            //if($cust->insurance_status == 'pending' || $cust->insurance_status == null) {
                $d = $this->CardPayment($odata);
                //var_dump($d); die();
                $order = new Order();
                $odata['order_id'] = $d['order_reference'];
                $id = $order->insert($odata);

                $nb = new \App\Models\Api\NurseBook();
                $data['status'] = 0;
                $data['order_id'] = $id;
                $data['special_instruction'] = $json->special_instruction;
                $booking_id = $nb->insert($data);

                return $this->respond([
                    'redirect_link' => $d['paymentLink'],
                    'booking_id' => $booking_id
                ]);
            //}
            
            
            
            
            // $orderModel = new Order();
            // $order_id = $orderModel->insert($odata);

            // $data['order_id'] = $order_id;
            // $data['special_instruction'] = $json->special_instruction;
            // $data['status'] = 0;

            // $this->model->insert($data);

            // return $this->respond([
            //     'status' => 'success',
            //     'msg' => 'order placed',
            //     'data' => [
            //         'order_id' => $odata['order_id']
            //     ]
            // ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
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

    public function CardPayment($data)
    {
        try {
            set_time_limit(0);
            // Test Keys
	        // $outletRef       ="57af269c-f285-4757-a6cc-9bc5451cc143";
	        // $apikey          = "YTM1ZWNmNDctMmQ2NS00M2NkLTg2NzgtNTNmYjllMjVhYjg3OmNlNTAzMTUzLTg2MjctNDk2NS05ZjU2LTc4OWVkMWVmYWFkNA==";

            // Live Keys
            $outletRef       = "3024a0f5-a490-47dd-99ce-2e92ce322384";
	        $apikey          = "MTA1MTNjYjItNzNhNC00NWU3LTljZmQtOGE0ODNjZjU2YTRjOjBhNmRjY2JjLWZmNjctNGVmZC1iYmU1LWI4Yjk3YjQ4YzBkOQ==";

	        // Test URLS 
	        // $idServiceURL  = "https://identity.sandbox.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token";           // set the identity service URL (example only)
	        // $txnServiceURL = "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

	        // LIVE URLS 
	        $idServiceURL  = "https://identity.ngenius-payments.com/auth/realms/NetworkInternational/protocol/openid-connect/token";           // set the identity service URL (example only)
	        $txnServiceURL = "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outletRef."/orders"; 

            $tokenHeaders  = array("Authorization: Basic ".$apikey, "Content-Type: application/x-www-form-urlencoded");
            $tokenResponse = $this->invokeCurlRequest("POST", $idServiceURL, $tokenHeaders, http_build_query(array('grant_type' => 'client_credentials')));
            $tokenResponse = json_decode($tokenResponse);

            $access_token  = $tokenResponse->access_token;
            
            $order = array();   

            $order['action']                      = "SALE";                                        // Transaction mode ("AUTH" = authorize only, no automatic settle/capture, "SALE" = authorize + automatic settle/capture)
            $order['amount']['currencyCode'] = "AED";                           // Payment currency ('AED' only for now)
            $order['amount']['value'] = $data['amount'] * 100;                                   // Minor units (1000 = 10.00 AED)
            $order['language']                    = "en";                           // Payment page language ('en' or 'ar' only)
            $order['emailAddress']                = $data['billing_email'];      
            $order['billingAddress']['firstName'] = $data['billing_firstname'];      
            $order['billingAddress']['lastName']  = $data['billing_lastname'];      
            $order['billingAddress']['address1']  = $data['billing_address'];      
            $order['billingAddress']['city']      = $data['billing_city'];      
            $order['billingAddress']['countryCode'] = "USA";      
                                              
            $order['merchantOrderReference'] = time();
            $order['merchantAttributes']['redirectUrl'] = site_url('api/payment/nurse/success'); //site_url('payment/doctor/success')
            $order['merchantAttributes']['skipConfirmationPage'] = true;
            $order['merchantAttributes']['cancelUrl']   = site_url('api/payment/nurse/fail'); //site_url('payment/doctor/failed')
            $order['merchantAttributes']['cancelText']  = 'Cancel';
            
            $order = json_encode($order);  

            $orderCreateHeaders  = array("Authorization: Bearer ".$access_token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json");
            //$orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $payment);
            $orderCreateResponse = $this->invokeCurlRequest("POST", $txnServiceURL, $orderCreateHeaders, $order);
            //var_dump($orderCreateResponse); die();

            $orderCreateResponse = json_decode($orderCreateResponse);
            //var_dump($orderCreateResponse); die();

            $d['paymentLink'] = $orderCreateResponse->_links->payment->href; 
            $d['order_reference'] = $orderCreateResponse->reference;
            //var_dump($d); die();
            return $d;

    	}
    	catch(\Exception $e) {
    		return $this->response->setStatusCode(500)->setJSON([
                'line' => $e->getLine(),
                'msg' => $e->getMessage()
            ]);
    	}
        //return header("Location: ".$paymentLink); 

    }
    
    

    public function isNurseAvailable($start_date, $end_date, $hours)
    {

    }
}