<?php
namespace App\Controllers\Api;

use Exception;
use CodeIgniter\API\ResponseTrait;
use App\Models\Api\CorporateBanner;
use CodeIgniter\RESTful\ResourceController;

Class BannerController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = "App\Models\Api\Banner";
    protected $format = "json";

    public function allBanners() {
        try {
            $banners = $this->model->findAll();
            return $this->respond([
                'status' => 'success',
                'result' => $banners
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                "msg" => $e->getMessage()
            ]);
        }
    }
    
    
        public function allCorporateBanners() {
        try {
            
            $customerModel = new \App\Models\Api\CorporateBanner();

            $banners = $customerModel->findAll();
            return $this->respond([
                'status' => 200,
                'data' => $banners
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                "msg" => $e->getMessage()
            ]);
        }
    }
    
    
    
    public function sendNotification()
    {
        $fcm = new \App\Libraries\FCM();
        $arrNotification = array();          
        $arrNotification["body"] = "PHP Push Notification";
        $arrNotification["title"] = "PHP Push Notification";
        $arrNotification["sound"] = "default";
        $arrNotification["type"] = 1;

        $fcm->sendNotification('dXWgZrTDRSeN3mXYSw0oBr:APA91bG6pUtd6MtPQzBn8s_u8SFwBeXQZpc2AKm8YlXXz0tN4122W_mu6Qej9C57GJ0LO9XajJQTM', $arrNotification, 'Android');
    }
    
    
    public function generate()
    {
        try {
            $appID = $this->request->getPost('app_id');
            $appCertificate = $this->request->getPost('certificate');
            $channelName = $this->request->getPost('channel_name');
            $uid = $this->request->getPost('uid');

            $token = new \App\Libraries\AgoraTokenGenerator($appID, $appCertificate, $channelName, $uid);
            return $this->respond([
                'token' => $token->buildToken()
            ]);
        }
        catch(Exception $e) {
            return $this->fail([
                'msg' => $e->getMessage()
            ]);
        }
        
    }
}