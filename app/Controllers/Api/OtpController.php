<?php

namespace App\Controllers\Api;



use Exception;

use App\Libraries\Sms;

use App\Models\Api\User;

use App\Models\Api\MobileVerification;

use CodeIgniter\RESTful\ResourceController;





class OtpController extends ResourceController

{

	protected $returnType = 'json';



	public function resendOTP()

	{

		try {



			$json = $this->request->getJSON();



			$otp = new Sms();

            $data = [

                "name" => ucfirst($json->type),

                "code" => rand(1000, 9999),

                "phone" => $json->mobile

            ];



            $response = $otp->sendOTP($data);



            $smsdata = [

                'user_id' => $json->user_id, 

                'mobile' => $json->mobile, 

                'code' => $data['code'], 

                'date_time' => date('Y-m-d H:i:s'), 

                'status' => 1

            ];

            $vmodel = new \App\Models\Api\MobileVerification();

            $vmodel->insert($smsdata);



            return $this->respond([

            	'status' => 'success'

            ]);



		}

		catch(Exception $e) {

			return $this->fail([

				'msg' => $e->getMessage(),

				'status' => 'error',

			]);

		}

	}



	public function verifyOTP()

	{

		try {

			$json = $this->request->getJSON();

			$model = new MobileVerification();



			$verify = $model->where([

				"code" => $json->code,

				"mobile" => $json->mobile,

				"status" => 1

			])->orderBy('id', 'DESC')->first();



			//var_dump($verify); die();



			if($verify) {

				$udata['phone_verified'] = 1;

				//var_dump($udata); die();

				$user = new User();

				$user->update($json->user_id, $udata);



				$model->delete($verify->id);



				return $this->respond([

					'status' => 'success'

				]);

			}

			else {

				throw new Exception("Otp did not match");

			}



		}

		catch(Exception $e) {

			return $this->fail([

				'msg' => $e->getMessage(),

				'status' => 'error',
				'line' => $e->getLine()

			]);

		}

	}

}