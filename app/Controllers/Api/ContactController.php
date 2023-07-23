<?php
namespace App\Controllers\Api;

use Exception;
use CodeIgniter\RESTful\ResourceController;

class ContactController extends ResourceController
{
    protected $modelName = 'App\Models\Api\ContactEnquiry';
    protected $format = 'json';

    public function addEnquiry()
    {
        try {
            $json = $this->request->getJSON();
            $data['name'] = $json->name;
            $data['email'] = $json->email;
            $data['phone'] = $json->phone;
            $data['category'] = $json->category;
            $data['message'] = $json->message;
            $data['status'] = 0;

            $this->model->insert($data);

            return $this->respond(['status' => true, 'msg' => 'Enquiry Submitted']);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage()]);
        }
    }
}