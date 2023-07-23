<?php
namespace App\Libraries;

Class Notification {
    
    function sendMessage($token, $reg_ids, $channel_id, $data){
        $content = array(
            "en" => $data['first_name'] . ' is Calling...'
        );
        $heading = array(
            "en" => 'Yes Maam Call'
        );
        
        $fields = array(
            'app_id' => "4194ddf0-8e31-4b8d-ac6b-e3999e7eed85",
            "headings" => $heading,
            'include_player_ids' => array($reg_ids),
            'data' => array(
                "first_name" => $data['first_name'], 
                "last_name" => $data['last_name'], 
                "type" => $data['call_type'], 
                "channel" => $channel_id, 
                "token"=> $token
            ),
            'large_icon' =>"ic_launcher_round.png",
            'contents' => $content
        );

        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        //print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic ZThkMzA3OTEtZTczYy00NzI0LTk4M2ItZTkzOWEyYjdkODVj'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        return $response;
    }

    function sendNurseBookingMessage($reg_ids, $data){
        $content = array(
            "en" => $data['customer_first_name'] . ' has booked you'
        );
        $heading = array(
            "en" => 'Yes Maam Call'
        );
        
        $fields = array(
            'app_id' => "4194ddf0-8e31-4b8d-ac6b-e3999e7eed85",
            "headings" => $heading,
            'include_player_ids' => array($reg_ids),
            'large_icon' =>"ic_launcher_round.png",
            'contents' => $content
        );

        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        //print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic ZThkMzA3OTEtZTczYy00NzI0LTk4M2ItZTkzOWEyYjdkODVj'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        return $response;
    }
}