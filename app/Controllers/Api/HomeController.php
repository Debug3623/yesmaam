<?php
namespace App\Controllers\Api;

use Exception;

use CodeIgniter\RESTful\ResourceController;



class HomeController extends ResourceController
{
    
    // public function getToken()
    // {
    //     //dd("Hello");
    //     if($this->request->getGet('channel')) {
    //         $url = "http://localhost:8080/access_token?channel=" . $this->request->getGet('channel');
    //         $ch = curl_init();
     
    //         // Return Page contents.
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             
    //         //grab URL and pass it to the variable.
    //         curl_setopt($ch, CURLOPT_URL, $url);
             
    //         $result = json_decode(curl_exec($ch));
            
    //         $result->channel = $this->request->getGet('channel'); 
    //         echo json_encode($result);
    //     }   
        
    // }
    
    public function getAgoraToken()
    {
        if($this->request->getGet('channel')) {
            $url = "http://localhost:8080/access_token?channel=" . $this->request->getGet('channel');
            $ch = curl_init();
     
            // Return Page contents.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             
            //grab URL and pass it to the variable.
            curl_setopt($ch, CURLOPT_URL, $url);
             
            $result = json_decode(curl_exec($ch));
            
            $result->channel = $this->request->getGet('channel'); 
            //echo json_encode($result);
            return $this->response->setStatusCode(200)->setJSON($result);
        }
    }
}