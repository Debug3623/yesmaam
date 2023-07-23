<?php

namespace App\Controllers\Api;



use Exception;

use App\Models\Api\User;

use App\Models\Api\Order;

use App\Models\Api\Customer;

use App\Models\Api\Settings;

use App\Models\Api\DoctorBooking;

use CodeIgniter\RESTful\ResourceController;



class DoctorController extends ResourceController

{

    protected $modelName = 'App\Models\Api\Doctor';

    protected $format = 'json';



    public function getBookings($user_id)

    {

        try {

            $doctor = $this->model->where(['user_id' => $user_id])->first();

            if(!$doctor) {

                throw new Exception("Doctor not Found");

            }



            $book = new \App\Models\Api\DoctorBooking();

            $bookings = $book->getDoctorBookings($doctor->id);

            return $this->respond(['status' => 'success', 'result' => $bookings]);

        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }



    public function updateProfile() {

        try {

            $json = $this->request->getJSON();

            $user_id = $json->user_id;

            

            $doctor = $this->model->where(['user_id' => $user_id])->first();

            if(!$doctor) {

                throw new Exception("Doctor not Found");

            }

            

            $user = new User();

            $u = $user->where(['id' => $user_id])->first();

            if(!$u) {

                throw new Exception("Invalid User Id");

            }

            

            $ddata['first_name'] = $json->first_name;

            $ddata['middle_name'] = $json->middle_name;

            $ddata['last_name'] = $json-> last_name;

            $ddata['dob'] = $json->dob;

            $data['gender'] = (isset($json->gender))?$json->gender:"male";

            $ddata['address'] = $json->address;

            $ddata['email'] = $json->email;

            $ddata['about_you'] = $json->about;

            $ddata['specialities'] = $json->specialities;

            $ddata['category'] = $json->category;

            $ddata['speaking_languages'] = $json->speaking_languages;

            $ddata['city'] = $json->city;

            $ddata['experience'] = $json->experience;

            $ddata['confirmed'] = 1;

            $ddata['status'] = 1;
            //$data['profile_photo'] = ($json->gender == 'male') ? "images/male_icon.png" : "images/female_icon.png";

            if($doctor->photo == 'images/male_icon.png' || $doctor->photo == 'images/female_icon.png' || $doctor->photo == '') {
                $data['photo'] = ($json->gender == 'male') ? "images/male_icon.png" : "images/female_icon.png";
            }

            

            $this->model->update($doctor->id, $ddata);

                

            $udata['name'] = $json->first_name;

            $udata['email'] = $json->email;

            //$udata['phone'] = $d->mobile;

            $user->update($user_id, $udata);

            

            return $this->respond(['status' => 'success', 'msg' => 'doctor Updated']);

            

        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }









    public function uploadPhoto()
    {
        try {
            $user_id = $this->request->getPost('user_id');
            $photo = $this->request->getFile('photo');

            $userM = new \App\Models\Api\User();
            $user = $userM->where(['id' => $user_id])->first();

            if(!$user) {
                throw new Exception("User Not Found");
            }

            $rules = [
                'photo' => [
                    'rules' => 'required|is_image[photo]'
                ]
            ];

           if(!$this->validate([
                'photo' => 'uploaded[photo]|is_image[photo]|max_size[photo,2024]',
            ])) {
                throw new Exception("Invalid Image Type");
            }

            $doctor = $this->model->where(['user_id' => $user_id])->first();
            // if(!$doctor) {
            //     throw new Exception("Doctor not Found");
            // }

            if($user->user_type == 'doctor') {
                $name = $photo->getRandomName();
                $loc = 'images/doctors/';

                if($photo->isValid() && !$photo->hasMoved()) {
                    $photo->move($loc, $name);
                    $ddata['photo'] = $loc . $name;
                    $this->model->update($doctor->id, $ddata);

                    if(is_file($loc . $doctor->photo)) {
                        if($doctor->photo != 'images/male.png' || $doctor->photo != 'images/female_icon.png') {
                            unlink($loc . $doctor->photo);
                        }
                    }
                }
            }
            else if($user->user_type == 'nurse') {
                $name = $photo->getRandomName();
                $loc = 'images/nurses/';

                if($photo->isValid() && !$photo->hasMoved()) {
                    $photo->move($loc, $name);
                    $ddata['photo'] = $loc . $name;

                    $nurseM = new \App\Models\Api\Nurse();
                    $nurse = $nurseM->where(['user_id' => $user->id])->first();
                    
                    $nurseM->update($nurse->id, $ddata);
                    //$this->model->update($doctor->id, $ddata);
                    if(is_file($loc . $nurse->photo) && ($nurse->photo != 'male_icon.png' || $nurse->photo != 'female_icon.png')) {
                        unlink($loc . $nurse->photo);
                    }
                }
            }

            return $this->respond([
                'status' => 'success', 
                'msg' => 'Profile Photo Updated',
                'result' => [
                    'url' => $loc . $name
                ]
            ]);
        }
        catch(Exception $e) {
            return $this->fail(['msg' => $e->getMessage(), 'line' => $e->getLine()]);
        }
    }

    

    // public function uploadPhoto()

    // {

    //     try {

    //         $user_id = $this->request->getPost('user_id');

    //         $photo = $this->request->getFile('photo');

    //         $rules = [

    //             'photo' => [

    //                 'rules' => 'required|is_image[photo]'

    //             ]

    //         ];



    //       if(!$this->validate([

    //             'photo' => 'uploaded[photo]|is_image[photo]|max_size[photo,2024]',

    //         ])) {

    //             throw new Exception("Invalid Image Type");

    //         }



    //         $doctor = $this->model->where(['user_id' => $user_id])->first();

    //         if(!$doctor) {

    //             throw new Exception("Doctor not Found");

    //         }

            



    //         $name = $photo->getRandomName();

    //         $loc = 'images/doctors/';



    //         if($photo->isValid() && !$photo->hasMoved()) {

    //             $photo->move($loc, $name);

    //             $ddata['photo'] = $loc . $name;

    //             $this->model->update($doctor->id, $ddata);



    //             if(is_file($loc . $doctor->photo)) {

    //                 unlink($loc . $doctor->photo);

    //             }

    //         }

            

            

    //         return $this->respond([

    //                 'status' => 'success', 

    //                 'msg' => 'Profile Photo Updated',

    //                 'result' => [

    //                     'url' => $loc . $name

    //                 ]

    //             ]);

            

    //     }

    //     catch(Exception $e) {

    //         return $this->fail(['msg' => $e->getMessage()]);

    //     }

    // }



    public function allDoctors()

    {

        try {

            if($this->request->getGet('cate')) {

                $nurses = $this->model->getAllDoctors($this->request->getGet('cate'));

            } else {

                $nurses = $this->model->getAllDoctors();

            }

            //var_dump($nurses); die();

            return $this->respond(['status' => 'success', 'data' => $nurses]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }
    
        public function doctorAvailable() {

        try {
            

            $user_id = $this->request->getPost('user_id');

            $plan = new \App\Models\Api\PurchasePlan();
            
             $data= $plan->distinct()->
             select('purchase_plans.id,purchase_plans.employee,purchase_plans.physio_doctor,
             purchase_plans.medical_camp,purchase_plans.total_price,purchase_plans.start_date as purchased_date,plans.title,plans.description,plans.package_price as basic_price,plans.symbol')
              
                ->where(['employees.user_id'=>$user_id,'purchase_plans.physio_doctor'=>'Yes'])
                ->join('employees','employees.company_code=purchase_plans.user_id')
                ->join('plans','plans.id=purchase_plans.plan_id')
                ->findAll();
                
                if($data)
                {
                    
                $user = new \App\Models\Api\Doctor();
                
                $data_s = $user->where(['category' => 4,'doctor_from'=>'app','available'=>'Yes'])->findAll(); 
                $data_s1 = $user->where(['category' => 9,'doctor_from'=>'app','available'=>'Yes'])->findAll(); 


                if($data_s)
                {
                    
                    return $this->respond(['status' => 200, 'data' => $data_s]);
                                
                }

                if($data_s1)
                {   
                    return $this->respond(['status' => 200, 'data' => $data_s1]);

                    
                }
                }
                else
                {
                    
                  $user = new \App\Models\Api\Doctor();
                $data_v = $user->where(['category' => 4,'doctor_from'=>'app'])->findAll();
                return $this->respond(['status' => 200, 'data' => $data_v]);
                }
                
  
                       
         }
        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 401, 'msg' => $e->getMessage()]);

        }

    }
    

    

    public function appointments($userID) {

        try {

           

            $doc = $this->model->where(['user_id' => $userID])->first();

            if(!$doc) {

                throw new Exception("Doctor not found");

            }



            $booking = new DoctorBooking();

            $bookings = $booking->getDoctorAppointments($doc->id);



            return $this->respond(['result' => $bookings]);

        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }

    

    public function callPatient()

    {

        try {

            $doctor = $this->model->where(['user_id' => $this->request->getPost('user_id')])->first();

            if(!$doctor) {

                throw new Exception("Doctor not found");

            }



            $cmodel = new Customer();

            $customer = $cmodel->where(['id' => $this->request->getPost('customer_id')])->first();

            if(!$customer) {

                throw new Exception("Customer not found");

            }





            $umodel = new User();

            $user = $umodel->where(['id' => $customer->user_id])->first();


            $token = $this->request->getPost('token');

            $type = $this->request->getPost('call_type');



            $notification = new \App\Libraries\Notification();

            $notification->sendMessage($token, $user->registration_id, $doctor->channel_id, ['first_name' => $customer->first_name, 'last_name' => $customer->last_name, 'call_type'=> $type]);



            return $this->respond(['status' => 'success']);

        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }

    

    public function changeDoctorAvailability()
    {
        try {
            $json = $this->request->getJSON();
            
            $id = $json->id;
            $type = $json->type;
            $status = $json->status;
            
            $model = null;
            
            if($type == 'doctor') {
                $model = new \App\Models\Api\Doctor();
            }
            else if($type == 'nurse') {
                $model = new \App\Models\Api\Nurse();
            }
            
            $user = $model->where(['id' => $id])->first();
            if(!$user) {
                throw new Exception($type . ' not found');
            }



            $data['available'] = $status;

            $model->update($user->id, $data);



            return $this->respond(['status' => 'success']);
        }
        catch(\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                "msg" => $e->getMessage()
            ]);
        }
    }

    public function changeAvailability($id, $available)

    {

        try {

            $doctor = $this->model->where(['id' => $id])->first();

            if(!$doctor) {

                throw new Exception('Doctor not found');

            }



            $data['available'] = $available;

            $this->model->update($doctor->id, $data);



            return $this->respond(['status' => 'success']);

            

        }

        catch(Exception $e) {

            return $this->fail(['msg' => $e->getMessage()]);

        }

    }

    public function deleteDoctor($id) {
		$model = new \App\Models\Api\Doctor();
		$doctor = $model->where(['id' => DecryptId($id)])->first();
		if($doctor) {
			$userM = new \App\Models\Api\User();
			$user = $userM->where(['id' => $doctor->user_id])->first();
			if($user) {
				$userM->delete($user->id);
			}

			if(is_file($doctor->photo)) {
				unlink($doctor->photo);
			}

			if(is_file($doctor->document)) {
				unlink($doctor->document);
			}
			$model->delete($doctor->id);
		}
	}

}