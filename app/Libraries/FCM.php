<?php
namespace App\Libraries;

Class FCM {
    public function sendNotification($registatoin_ids, $notification, $device_type)
    {   
        // $arrNotification = array();          
        // $arrNotification["body"] = $data['body']; //"PHP Push Notification";
        // $arrNotification["title"] = $data['title']; //"PHP Push Notification";
        // $arrNotification["sound"] = $data['sound']; //"default";
        // $arrNotification["type"] = 1;
    
        $url = 'https://fcm.googleapis.com/fcm/send';
        if($device_type == "Android"){
            $fields = array(
                'to' => $registatoin_ids,
                'data' => $notification
            );
        } else {
            $fields = array(
                'to' => $registatoin_ids,
                'notification' => $notification
            );
        }
        // Firebase API Key
        $key = 'AAAA26o56WU:APA91bEI279m1xOGtq81k2MQCbl81AjAW9HyXV2Y8ThI_tf1DqsKuVNcksntbuTBolmulwFiTrf-F2sY-rPWeOvx13H1M0TcZ9Zp74FhOI24hQR1FCpICOSDkVzOUYURgElmLve6a6D9';
        //dd($registatoin_ids);
        $headers = array('Authorization:key=' . $key,'Content-Type:application/json');
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        print_r($result);
        
    }
}