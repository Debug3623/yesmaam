<?php

namespace App\Controllers\Api;

use Exception;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class RequirementController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = "App\Models\Api\Requirement";
    protected $format = "json";

    public function postRequirement()
    {
        try {
            $json = $this->request->getJSON();
            $customer = new \App\Models\Api\Customer();
            $cust = $customer->where(['user_id' => $json->user_id])->first();

            if(!$cust) {
                throw new Exception("Customer not found");
            }

            $data['user_id'] = $cust->id;
            $data['category'] = $json->category;
            $data['start_date'] = date('Y-m-d', strtotime($json->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($json->end_date));
            
            $data['start_time'] = date('H:i:s', strtotime($json->start_time));
            $data['end_time'] = date('H:i:s', strtotime($json->end_time));
            // $data['latitude'] = $json->latitude;
            // $data['longitude'] = $json->longitude;
            $data['area'] = $json->area;

            $data['details'] = $json->details;
            $data['budget'] = $json->budget;
            $data['status'] = 'pending';
            $this->model->insert($data);

            return $this->respond([
                'status' => 'success',
                'msg' => 'Requirement Posted'
            ]);
        }

        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }



    public function index($id = null)
    {
        try { 
            $requirements = $this->model->getAllReuirements();
            return $this->respond([
                'status' => 'success',
                'result' => $requirements
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function singleRequirement($id)
    {
        try {
            $requirements = $this->model->getAllReuirements($id);
            return $this->respond([
                'status' => 'success',
                'result' => $requirements
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function customerRequirements($user_id)
    {
        try {
            $customer = new \App\Models\Api\Customer();
            $cust = $customer->where(['user_id' => $user_id])->first();

            if(!$cust) {
                throw new Exception("Customer not found");
            }

            $requirements = $this->model->getCustomerRequirements($cust->id);
            return $this->respond([
                'status' => 'success',
                'result' => $requirements
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                "msg" => $e->getMessage()
            ]);
        }
    }
}

