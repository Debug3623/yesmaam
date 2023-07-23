<?php

namespace App\Controllers\Api;
use Exception;
use App\Models\Api\Doctor;

use CodeIgniter\RESTful\ResourceController;



class CategoryController extends ResourceController

{

    protected $modelName = 'App\Models\Api\Category';

    protected $format = 'json';



    public function allNurseCategories()

    {

        try {

            $data = $this->model->where([

                'cate_for' => 'nurse'

            ])->findAll();

            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }
    
    public function allDoctCategories()

    {

        try {

            $data = $this->model->where([

                'cate_for' => 'doctor'

            ])->findAll();

            return $this->respond(['status' => 'success', 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'msg' => $e->getMessage()]);

        }

    }



    public function allDoctorCategories()

    {

           try {
            
            $user_id = $this->request->getPost('user_id');

            $plan = new \App\Models\Api\PurchasePlan();
            
             $data= $plan->distinct()->
             select('purchase_plans.id,purchase_plans.employee,purchase_plans.physio_doctor,
             purchase_plans.medical_camp,purchase_plans.total_price,purchase_plans.start_date as purchased_date,plans.title,plans.description,plans.package_price as basic_price,plans.symbol')
              
                ->where('employees.user_id',$user_id)
                ->where('purchase_plans.physio_doctor',"Yes")
                ->join('employees','employees.company_code=purchase_plans.user_id')
                ->join('plans','plans.id=purchase_plans.plan_id')
                ->findAll();
                
                if($data)
                {
                    
                $doctor = $this->model->where([

                'cate_for' => 'doctor',
                'name'=>'physiotherapist',
             
                ])->Orwhere(['name'=>'General Practitioner'])->findAll();
                  return $this->respond(['status' => 'success', 'data' => $doctor]);

                }
                else
                {
                    
                $doctors = $this->model->where([

                'cate_for' => 'doctor',
                'name'=>'General Practitioner',

                ])->findAll();
                
                return $this->respond(['status' => 200, 'data' => $doctors]);

                }
                
   
        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 401, 'msg' => $e->getMessage()]);

        }

    }

    
    
    

    public function allCategories()

    {

        try {

            $data = $this->model->findAll();

            return $this->respond(['status' => 200, 'data' => $data]);

        }   

        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 401, 'msg' => $e->getMessage()]);

        }

    }

    public function getBabySitterCategories()
    {
        try {
            $cate = $this->model->where([
                'cate_for' => 'babysitter'
            ])->findAll();
            return $this->respond([
                'result' => $cate
            ]);
        } 
        catch(Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error', 'msg' => $e->getMessage()
            ]);
        }
    }
    
    
    public function categoryWiseDoctor()

    {

        try {
            
            $category_id = $this->request->getPost('category');
            
            $user_id = $this->request->getPost('user_id');

            $user = new \App\Models\Api\Doctor();
            $data = $user->where(['category' => $category_id,'doctor_from'=>'app'])->findAll();
            
        
            
            if($data)
            {

            return $this->respond(['status' => 200, 'data' => $data]);
            }
            elseif($category_id== 'all' && $user_id)
            {
                
    
            $plan = new \App\Models\Api\PurchasePlan();
            
             $data= $plan->distinct()->
             select('purchase_plans.id,purchase_plans.employee,purchase_plans.physio_doctor,
             purchase_plans.medical_camp,purchase_plans.total_price,purchase_plans.start_date as purchased_date,plans.title,plans.description,plans.package_price as basic_price,plans.symbol')
              
                ->where('employees.user_id',$user_id)
                ->where('purchase_plans.physio_doctor',"Yes")
                ->join('employees','employees.company_code=purchase_plans.user_id')
                ->join('plans','plans.id=purchase_plans.plan_id')
                ->findAll();
                
                if($data)
                {
                    
                $user = new \App\Models\Api\Doctor();
                $data_s = $user->where(['category' => 4,'doctor_from'=>'app'])->Orwhere(['category' => 9,'doctor_from'=>'app'])->findAll(); 
                return $this->respond(['status' => 200, 'data' => $data_s]);
                }
                else
                {
                    
                $user = new \App\Models\Api\Doctor();
                $data_v = $user->where(['category' => 4,'doctor_from'=>'app'])->findAll();
                return $this->respond(['status' => 200, 'data' => $data_v]);
                }
                
  

            }
            else
            {
                return $this->respond(['status' => 200, 'data' => []]);

            }
                       
         }
        catch(Exception $e) {

            return $this->response->setStatusCode(500)->setJSON(['status' => 401, 'msg' => $e->getMessage()]);

        }

    }

}