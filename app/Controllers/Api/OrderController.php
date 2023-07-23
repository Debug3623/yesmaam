<?php
namespace App\Controllers\Api;

use Exception;
use App\Models\Api\Customer;
use App\Models\Api\NurseBook;
use App\Models\Api\DoctorBooking;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class OrderController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Api\Order';
    protected $format = 'json';

    public function updateOrder($id)
    {
        try {
            $json = $this->request->getJSON();
            $data['order_id'] = $json->order_id;
            $data['payment_id'] = $json->transaction_id;
            $data['payment_status'] = 'completed';

            $order = $this->model->where([
                'order_id' => $json->order_id
            ])->first();

            if(!$order) {
                throw new Exception("Order not found");
            }

            $this->model->update($order->id, $data);
            $booking = null;
            if($order->order_for == 'nurse') {
                $booking = new NurseBook();
            } 
            else if($order->order_for == 'doctor') {
                $booking = new DoctorBooking();
            }
            else {
                throw new Exception("Order Details not found");
            }
            $book = $booking->where([
                'order_id' => $order->id
            ])->first();
            $bdata['status'] = 1;
            $booking->update($book->id, $bdata);

            return $this->respond([
                'status' => 'success',
                'msg' => 'Order Updated'
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getOrders()
    {
        // Services, Requirements - Pending
        try {
            $json = $this->request->getJSON();
            $cus = new Customer();
            $customer = $cus->where([
                'user_id' => $json->user_id,
                
            ])->first();

            if(!$customer) {
                throw new Exception("Customer not found");
            }

            $orders = $this->model->where([
                'customer_id' => $customer->id,
                'order_for' => 'service',
                'order_status' => 'completed'
            ])->findAll();

            return $this->respond([
                'status' => 'success',
                'data' => $orders
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getSingleOrder()
    {
        try {
            $json = $this->request->getJSON();
            
            $orders = $this->model->where([
                'order_id' => $json->order_id
            ])->first();

            return $this->respond([
                'status' => 'success',
                'data' => $orders
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