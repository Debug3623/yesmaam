<?php

namespace App\Controllers\Api;



use Exception;

use App\Models\Api\User;

use CodeIgniter\RESTful\ResourceController;



class NurseController extends ResourceController

{

    protected $modelName = 'App\Models\Api\Nurse';

    protected $format = 'json';



    public function editProfile()

    {

        try {

            $json = $this->request->getJSON();

            $nurse = $this->model->where([

                'user_id' => $json->user_id

            ])->first();



            if(!$nurse) {

                throw new Exception("Nurse not found");

            }

            

            $userModel = new User();

            $user = $userModel->where(['id' => $json->user_id])->first();

            if(!$user) {

                throw new Exception("Invalid User ID");

            }



            $data['first_name'] = $json->first_name;

            $data['middle_name'] = $json->middle_name;

            $data['gender'] = (isset($json->gender))?$json->gender:"male";

            $data['last_name'] = $json->last_name;

            $data['email'] = $json->email;

            //$data['phone'] = $json->phone;

            $data['work_title'] = $json->work_title;

            $data['about'] = $json->about;

            $data['expertise'] = $json->expertise;

            $data['category'] = $json->category;

            $data['working_hours'] = $json->working_hours;

            $data['date_of_birth'] = $json->dob;

            $data['marital_status'] = $json->maritial_status;

            $data['skills'] = $json->skills;

            //$data['visa_type'] = $this->request->getPost('visa_type');

            //$data['profile_photo'] = ($json->gender == 'male') ? "images/male_icon.png" : "images/female_icon.png";
            if($nurse->photo == 'images/male_icon.png' || $nurse->photo == 'images/female_icon.png' || $nurse->photo == '') {
                $data['photo'] = ($json->gender == 'male') ? "images/male_icon.png" : "images/female_icon.png";
            }
            

            $data['working_type'] = $json->working_type;

            //$data['nationality'] = $json->nationality;

            $data['experience'] = $json->experience;

            $data['city'] = $json->city;

            $data['address'] = $json->address;
            $data['speaking_languages'] = $json->speaking_languages;

            //$data['EID'] =$json->EID;

            //$data['passport_no'] = $json->passport_no;

            //$data['passport'] = $json->passport;

            $data['user_id'] = $json->user_id;

            $data['confirmed'] = 1;

            $data['status'] = 1;



            

            $this->model->update($nurse->id, $data);

            

            $udata['name'] = $json->first_name;

            $udata['email'] = $json->email;

            

            $userModel->update($json->user_id, $udata);

            

            return $this->respond(['status' => 'success', 'msg' => "Nurse Profile Updated"]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }





    public function allNurses()

    {

        try {

            if($this->request->getGet('cate')) {

                $nurses = $this->model->getAllNurses($this->request->getGet('cate'));

            } else {

                $nurses = $this->model->getAllNurses();

            }

            

            return $this->respond(['status' => 'success', 'data' => $nurses]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }
    public function getAllNurses()
    {
        try {
            helper(['url']);

            $json = $this->request->getJSON();
            $umodel = new \App\Models\Api\User();
            if(isset($json->user_id) || !empty($json->user_id)) {
                $user = $umodel->where(['id' => $json->user_id])->first();
                //var_dump($user); die();
                $clat = $user->latitude;
                $clong = $user->longitude;
            }
            else {
                $clat = $json->latitude;
                $clong = $json->longitude;
            }
            
            $nurses = $nurses = $this->model->getAllNursesWithLatLong();
            $dd = [];

            foreach($nurses as $n) {
                if($n->latitude == '' || $n->longitude == '') {
                    continue;
                }
                $lat1 = $clat;
                $long1 = $clong;

                $lat2 = $n->latitude;
                $long2 = $n->longitude;
                $distance = twopoints_on_earth((float)$lat1, (float)$long1, (float)$lat2, (float)$long2);
                if($distance <= 5) {
                    $dd[] = $n;
                }
            }

            return $this->respond(['data' => $dd]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error', 
                'msg' => $e->getMessage(),
                "line" => $e->getLine(),
                "file" => $e->getFile()
            ]);
        }
    }

    public function myBookings()
    {
        try {
            $json = $this->request->getJSON();
            $user = $this->model->where([
                'user_id' => $json->user_id
            ])->first();
            //var_dump($user); die();
            if(!$user) {
                throw new Exception("Nurse not found");
            }

            $nbmodel = new \App\Models\Api\NurseBook();
            $bookings = $nbmodel->getBookings2($user->id);
            return $this->respond([
                'result' => $bookings
            ]);
        }
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'msg' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }
}