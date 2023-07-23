<?php
namespace App\Controllers\Api;

use Exception;
use App\Models\Api\Customer;
use CodeIgniter\RESTful\ResourceController;

class AddressController extends ResourceController
{
    protected $modelName = 'App\Models\Api\Address';
    protected $format = 'json';
    
    public function allAddresses()
    {
        try {
            $json = $this->request->getJSON();
            $customer = new Customer();
            $cus = $customer->where([
                'user_id' => $json->user_id
            ])->first();
            if(!$cus) {
                throw new Exception("No customer found");
            }

            $addesses = $this->model->where([
                'customer_id' => $cus->id
            ])->findAll();

            return $this->respond([
                'status' => 'success',
                'data' => $addesses
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function addAddress()
    {
        try {
            $json = $this->request->getJSON();
            $customer = new Customer();
            $cus = $customer->where([
                'user_id' => $json->user_id
            ])->first();
            if(!$cus) {
                throw new Exception("No customer found");
            }

            $data['customer_id'] = $cus->id;
            $data['address_name'] = $json->address;
            $data['city'] = $json->city;
            $data['pincode'] = $json->pincode;
            $data['status'] = 1;

            $this->model->insert($data);
            return $this->respond([
                'status' => 'success',
                'msg' => 'Address added'
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function deleteAddress()
    {
        try {
            $json = $this->request->getJSON();
            $add = $this->model->where(['id' => $json->address_id])->first();
            if(!$add) {
                throw new Exception("Invalid Id");
            }
            
            $this->model->delete($json->address_id);
            return $this->respond([
                'status' => 'success',
                'msg' => 'Address deleted'
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
