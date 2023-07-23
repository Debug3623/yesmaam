<?php

namespace App\Controllers;

use App\Models\Nurse;
use App\Models\Doctor;
use App\Libraries\Email;
use App\Models\Category;

class Home extends BaseController
{
  
  	public function index3()
    {
		$where = $this->request->getGet();
		$doc = new Doctor();
		$data['speciality'] = ['Orthopedics', 'Internal Medicine', 'Obstetrics and Gynecology', 'Dermatology', 'Radiology'];
      
      	$cate = new Category();
		$data['categories'] = $cate->where(['status' => 1, 'cate_for' => 'doctor'])->findAll();

		$w = [];

		if(isset($where['location']) && !empty($where['location'])) {
			$w['city'] = $where['location'];
		}
		
		if(isset($where['work_type']) && !empty($where['work_type'])) {
			$w['category'] = $where['work_type'];
			
		}
		//dd($w);
		if($where) {
			$data['nurses'] = $doc->searchDoctors($w);
		}
		else {
			$data['nurses'] = $doc->getDoctors();
		}
		//dd($data);
		return view('index3', $data);
        //return view('', $data);
    }
    public function index()
    {
        //dd(date('Y-m-d H:i:s', time()));
        $doctor = new Doctor();
        $data['doctors'] = $doctor->limit(6)->getHomeDoctor();

        $nurse = new Nurse();
        $data['nurses'] = $nurse->limit(6)->getHomeNurses();

        //dd($data);
        return view('index2', $data);
    }

    public function billing()
    {
      $data['amount'] = 4000;
      $data['payment_type'] = 'Card';
      $data['order_date'] = '2022-03-07';
      $data['order_id'] = 'OD12345';
      $data['order_for'] = 'nurse';
      $data['item_id'] = 1;
      $data['payment_id'] = 'TX12345';
      $data['billing_firstname'] = 'Amar';
      $data['billing_lastname'] = 'Agrawal';
      $data['billing_email'] = 'amagrawal0090@gmail.com';
      $data['billing_address'] = 'A-401 Rama Empire, Satav Square, Jatherpeth, Akola';
      $data['billing_city'] = 'Akola';
      $data['billing_country_code'] = 'AUE';
      $data['payment_status'] = 'Complete';
      $data['date_booked_for'] = '2022-03-12 13:32:00';
      $data['profile_photo'] = 'images/nurses/nurse.png';
      $data['nurse_fname'] = 'Poonam';
      $data['nurse_lname'] = 'Pandey';
      
      $d['order'] = (object)$data;
      return view('templates/nurse_order_success', $d);
    }
  
	public function mail()
	{
    	try {
        
            /*
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.zoho.in',
                'smtp_port' => 465,
                'smtp_user' => 'admin@yesmaam.ae',
                'smtp_pass' => 'A9qBsw5UVbqk',
                'mailtype'  => 'html', 
                'charset'   => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $result = $this->email->send();
            */

            $email = \Config\Services::email();
			$config['protocol'] = 'smtp';
            //$config['mailPath'] = '/usr/sbin/sendmail';
            $config['charset']  = 'iso-8859-1';
            $config['SMTPHost']	= 'smtp.zoho.in';
            $config['SMTPUser']	= 'admin@yesmaam.ae';
            $config['SMTPPass']	= 'A9qBsw5UVbqk';
            $config['SMTPPort']	= 465;
          	$config['SMTPCrypto'] = 'ssl';

            $email->initialize($config);
          	
            $email->setFrom('admin@yesmaam.ae', 'YesMaam');
            $email->setTo('amagrawal0090@gmail.com'); 
            //$email->setTo('vidur.sharmapp@gmail.com');
            //$email->setCC('another@another-example.com');
            //$email->setBCC('them@their-example.com');

            $email->setSubject('Email Test');
            $email->setMessage('Testing the email class.');

            return $email->send();
      	}
      	catch(\Exception $e) {
        	die("Unable to send Email");
        }
	}

    public function email()
    {
        try {
            $email = \Config\Services::email();
            $config['charset']  = 'iso-8859-1';
            $config['SMTPHost']  = 'smtp.yesmaam.ae';
            $config['SMTPUser']  = 'support@yesmaam.ae';
            $config['SMTPPass']  = 'Yesmaam@2022';
            //SMTPPort
            $email->initialize($config);

            $email->setFrom('support@yesmaam.ae', 'Yesmaam');
            $email->setTo('amagrawal0090@gmail.com');

            $email->setSubject('Welcome to Yesmaam');
            $email->setMessage('Welcome to Yesmaam App. Thank you for reaching to us');

            $email->send();
        }
        catch(\Exception $e) {
            die($e->getMessage());
        }
    }

    public function email2()
    {
        $email = new Email();
        $email->sendMail2('','','');
    }
}
