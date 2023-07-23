<?php
namespace App\Controllers\Api;

use Exception;
use App\Models\Api\Bid;
use App\Models\Api\User;
use App\Models\Api\Nurse;
use App\Models\Api\Customer;
use App\Models\Api\Requirement;
use App\Models\Api\RequirementBook;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

Class BidController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Api\Bid';
    protected $format = 'json';

    public function placeBid()
    {
        try {
            $json = $this->request->getJSON();
            $nmodel =  new Nurse();
            $nurse = $nmodel->where(['user_id' => $json->nurse_user_id])->first();

            if(!$nurse) {
                throw new Exception("Invalid User Id");
            }

            $bid = $this->model->where(['nurse_id' => $nurse->id, 'requirement_id' => $json->requirement_id])->first();
            if($bid) {
                throw new Exception("Bid already Placed");
            }

            $data['nurse_id'] = $nurse->id;
            $data['requirement_id'] = $json->requirement_id;
            $data['price'] = $json->price;
            $data['message'] = $json->message;
            $data['status'] = 0; //
            $this->model->insert($data);

            return $this->respond([
                'status' => 'success',
                'msg' => 'Bid Placed'
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function acceptBid()
    {
        try {
            $json = $this->request->getJSON();
            $data['requirement_id'] = $json->requirement_id;
            $data['bid_id'] = $json->bid_id;
            $data['nurse_id'] = '';
            $data['customer_id'] = '';
            $data['booking_date_time'] = date('Y-m-d H:i:s');
            $data['amount'] = '';
            $data['status'] = 'progress'; // pending

            $requirement = new Requirement();
            $req = $requirement->where(['id' => $data['requirement_id']])->first();
            if(!$req) {
                throw new Exception("Invalid Requirement ID");
            }

            $bidModel = new Bid();
            $bid = $bidModel->where(['id' => $data['bid_id']])->first();
            if(!$bid) {
                throw new Exception("Invalid Bid ID");
            }

            $customerModel = new \App\Models\Api\Customer();
            $cust = $customerModel->where(['user_id' => $json->user_id])->first();
            if(!$cust) {
                throw new Exception("Customer not Found");
            }
            $start_date = $req->start_date . " " . $req->start_time;
            $end_date = $req->end_date . " " . $req->end_time;
            $rate = getBidPrice2($start_date, $end_date, $bid->price);
            
            //$rate = getBidPrice($req->start_date, $req->end_date, $req->start_time, $req->end_time, $bid->price);
            $data['nurse_id'] = $bid->nurse_id;
            $data['amount'] = $rate;
            $data['customer_id'] = $cust->id;


            $odata['customer_id'] = $cust->id;
            $odata['amount'] = $rate;
            $odata['payment_type'] = $json->payment_type;
            $odata['order_date'] = date('Y-m-d');
            $odata['order_id'] = 'YMSO' . date('ymd') . uniqid();
            $odata['order_for'] = 'requirement';
            $odata['item_id'] = $data['requirement_id'];
            $odata['payment_id'] = '';
            $odata['billing_firstname'] = $json->billing_firstname;
            $odata['billing_lastname'] = $json->billing_lastname;
            $odata['billing_email'] = $json->billing_email;
            $odata['billing_address'] = $json->billing_address;
            $odata['billing_city'] = $json->billing_city;
            $odata['billing_country_code'] = $json->billing_country_code;
            $odata['payment_status'] = "pending"; //($json->payment_type == 'cod') ? "pending":"completed";

            //if($cust->insurance_status == 'pending' || $cust->insurance_status == 'not available' || $cust->insurance_status == null) {
                $d = $this->CardPayment($odata);
                //var_dump($d); die();
                $order = new \App\Models\Api\Order();
                $odata['order_id'] = $d['order_reference'];
                $id = $order->insert($odata);

                $nb = new \App\Models\Api\RequirementBook();
                $data['status'] = 'progress'; //'pending';
                $data['order_id'] = $id;
                //$data['special_instruction'] = $json->special_instruction;
                $booking_id = $nb->insert($data);

                return $this->respond([
                    'redirect_link' => $d['paymentLink'],
                    'booking_id' => $booking_id
                ]);
            //}

            
            // $data['status'] = 'completed';
            // $book = new RequirementBook();
            // $book->insert($data);

            // $bdata['status'] = '1';
            // $requirement->update($data['requirement_id'], $bdata);

            // return $this->respond([
            //     'status' => 'success',
            //     'msg' => "Bid Confirmed"
            // ]);
            
        }
        catch(Exception $e) {
            return $this->fail([
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
            $order['merchantAttributes']['redirectUrl'] = site_url('api/payment/requirement/success'); //site_url('payment/doctor/success')
            $order['merchantAttributes']['skipConfirmationPage'] = true;
            $order['merchantAttributes']['cancelUrl']   = site_url('api/payment/requirement/fail'); //site_url('payment/doctor/failed')
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
    

    public function nurseBids($nurse_user_id)
    {
        try {
            $nurseModel = new Nurse();
            $user = $nurseModel->where(['user_id' => $nurse_user_id])->first();
            
            if(!$user) {
                throw new Exception("User not Found");
            }
            
            $bidModel = new Bid();
            $bids = $bidModel->nurseBids($user->id);
            
            return $this->respond([
                "status" => "success",
                "result" => $bids
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }
    
    public function requirementBids($requirement_id) {
        try {
            $requirementModel = new Requirement();
            $req = $requirementModel->where(['id' => $requirement_id])->first();
            
            if(!$req) {
                throw new Exception("Invalid Requirement ID");
            }
            
            $bidModel = new Bid();
            $bids = $bidModel->getAllBids($req->id);
            
            return $this->respond([
                "status" => "success",
                "result" => $bids
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function cancelBid($bidId)
    {
        try {
            $bid = $this->model->where(['id' => $bidId])->first();
            if(!$bid) {
                throw new Exception("Bid not found");
            }

            $this->model->delete($bid->id);
            return $this->respond(['msg' => 'Bid Cancelled']);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }
}