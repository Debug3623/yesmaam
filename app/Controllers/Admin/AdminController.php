<?php
namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Nurse;
use App\Models\Doctor;
use App\Models\Customer;
use App\Models\Settings;

class AdminController extends \App\Controllers\BaseController
{
	public function login() {
		//echo password_hash('123456', PASSWORD_DEFAULT, ['cost' => 12]); die();
		helper('form');
		$data['msg'] = session()->getFlashdata('msg');

		if($this->request->getMethod() == 'post') {
			$username = $this->request->getPost('username');
			$password = (string)$this->request->getPost('password');

			$model = new \App\Models\Admin();
			$admin = $model->where(['username' => $username])->first();
			//var_dump(password_verify($password, $admin->password)); die();
			if($admin) {
				if(password_verify($password, $admin->password)) {
					
					$this->setAdmin($admin);
					return redirect('admin/dashboard');
					
				}
				else {
					$data['errors'][] = "Username or Password did not match.";
					return view('admin/login', $data);
				}
			}
			else {
				$data['errors'][] = "User not found";
				return view('admin/login', $data);
			}
		}
		else {
			return view('admin/login', $data);
		}
	}

	public function setAdmin($user) {
		$data = [
			'name' => $user->name,
			'email' => $user->email,
			'username' => $user->username,
			'user_type' => 'admin',
			'business_name' => 'Yess Maam',
		];
		session()->set('admin', $data);
	}

	public function logout()
	{
		session()->remove('admin');
		return redirect('admin/login');
	}

	public function dashboard()
	{
		$doc = new Doctor();
		$data['n_docs'] = $doc->countAll();

		$nurse = new Nurse();
		$data['n_nurses'] = $nurse->countAll();

		$cus = new Customer();
		$data['n_cus'] = $cus->countAll();


		return view('admin/dashboard', $data);
	}

	public function settings()
	{
		helper('form');
		$data['msg'] = session()->getFlashdata('msg');

		$setting = new Settings();
		$data['setting'] = $setting->first();

		if($this->request->getMethod() == 'post') {
			$rules = [
				'first_name' => [
					'label' => 'Store Name',
					'rules' => 'trim|required'
				],
				'nurse_hour_rate' => [
					'label' => 'Nurse Hour Rate',
					'rules' => 'trim|required'
				],
				'nurse_week_rate' => [
					'label' => 'Nurse Week Rate',
					'rules' => 'trim|required'
				],
				'nurse_month_rate' => [
					'label' => 'Nurse Month Rate',
					'rules' => 'trim|required'
				],
				'doctor_hour_rate' => [
					'label' => 'Doctor Hour Rate',
					'rules' => 'trim|required'
				],
				'doctor_week_rate' => [
					'label' => 'Doctor Week Rate',
					'rules' => 'trim|required'
				],
				'doctor_month_rate' => [
					'label' => 'Doctor Month Rate',
					'rules' => 'trim|required'
				],
				'currency_type' => [
					'label' => 'Currency Code',
					'rules' => 'trim|required'
				],
				'currency_icon' => [
					'label' => 'Currency Icon',
					'rules' => 'trim|required'
				]
			];
			//dd($_POST);
			if($this->validate($rules)) {
				$sdata['store_name'] = $this->request->getPost('first_name');
				$sdata['nurse_hour_rate'] = $this->request->getPost('nurse_hour_rate');
				$sdata['nurse_week_rate'] = $this->request->getPost('nurse_week_rate');
				$sdata['nurse_month_rate'] = $this->request->getPost('nurse_month_rate');
				$sdata['doctor_hour_rate'] = $this->request->getPost('doctor_hour_rate');
				$sdata['doctor_week_rate'] = $this->request->getPost('doctor_week_rate');
				$sdata['doctor_month_rate'] = $this->request->getPost('doctor_month_rate');
				$sdata['currency_type'] = $this->request->getPost('currency_type');
				$sdata['currency_icon'] = $this->request->getPost('currency_icon');
				$sdata['status'] = 1;


				$setting->update(1, $sdata);

				session()->setFlashdata('msg', 'Settings Updated');
				return redirect()->to('admin/settings');
			}
			else {
				$data['validator'] = $this->validator;
				return view('admin/settings', $data);
			}
		}
		else {
			return view('admin/settings', $data);
		}
	}
}