<?php
namespace App\Controllers\Front;

use App\Models\User;
use App\Models\Customer;
use App\Libraries\Email;

class CustomerController extends \App\Controllers\BaseController
{
	public function login()
	{
		helper('form');
		$data['msg'] = session()->getFlashdata('msg');
		$data['errmsg'] = '';
		

		if($this->request->getMethod() == 'post') {
			$rules = [
				'username' => [
					'label' => 'Username',
					'rules' => 'trim|required',
                  	
				],
				'password' => [
					'label' => 'Password',
					'rules' => 'trim|required'
				]
			];

			if($this->validate($rules)) {
				$customer = new User();
				$user = $customer->where(['username' => $this->request->getPost('username'), 'user_type' => 'customer'])->first();

				if(!$user) {
					$data['errmsg'] = 'User not found';
					return view('customers/login', $data);
				}
				if(password_verify($this->request->getPost('username'), $user->password)) {
					$data['errmsg'] = 'Email or Password did not match.';
					return view('customers/login', $data);
				}

				/*
				if($user->email_verified == 0) {
					$data['errmsg'] = 'Please Verify your email before login';
					return view('customers/login', $data);
				}	
				*/
				$this->setCustomer($user);
				$rurl = session()->get('rurl');
				
				session()->remove('rurl');

				if(!empty($rurl)) {
					return redirect()->to($rurl);
				}

				return redirect()->to('customer/profile');
			}
			else {
				$data['validator'] = $this->validator;
				return view('customers/login', $data);
			}
		}
		else {
			return view('customers/login', $data);
		}
	}

	public function setCustomer($user)
	{
		$data['name'] = $user->name;
		$data['username'] = $user->username;
		$data['email'] = $user->email;
		$data['login_time'] = date('Y-m-d H:i:s');
		session()->set('customer', $data);
	}

	public function register()
	{
		helper('form');
		$data['msg'] = session()->getFlashdata('msg');

		if($this->request->getMethod() == 'post') {
			$rules = [
				'firstname' => [
					'label' => 'First Name',
					'rules' => 'trim|required'
				],
				'middlename' => [
					'label' => 'Middle Name',
					'rules' => 'trim'
				],
				'lastname' => [
					'label' => 'Last Name',
					'rules' => 'trim|required'
				],
				'address' => [
					'label' => 'Address',
					'rules' => 'trim|required'
				],
				'email' => [
					'label' => 'Email',
					'rules' => 'trim|required|is_unique[users.email]',
                  	'errors' => [
                		'is_unique' => 'Your {field} id is already Taken.',
            		]
				],
				'phone' => [
					'label' => 'Phone',
					'rules' => 'trim|required|exact_length[9]',
                  	'errors' => [
                    	'exact_length' => 'Please do not include country code in your {field} number'
                    ],
				],
				'password' => [
					'label' => 'Password',
					'rules' => 'trim|required'
				],
				'password2' => [
					'label' => 'Re-Type Password',
					'rules' => 'trim|required|matches[password]',
                  	'errors' => [
                		'matches' => 'Your {field} field did not match.',
            		]
				],
				'terms' => [
					'label' => 'Terms & Conditions',
					'rules' => 'trim|required',
                  	'errors' => [
                    	'required' => 'You have to agree with our Terms and Conditions to proceed forward'
                    ],
				],
			];
          
          	

			if($this->validate($rules)) {
				$user = new User();
				$udata['name'] = $this->request->getPost('firstname') . ' ' . $this->request->getPost('lastname');
				$udata['email'] = $this->request->getPost('email'); 
				$udata['username'] = $this->request->getPost('email'); 
				$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]); 
				$udata['user_type'] = 'customer'; 
				$udata['status'] = 1; 

				$id = $user->insert($udata);

				$cdata['first_name'] = $this->request->getPost('firstname'); 
				$cdata['middle_name'] = $this->request->getPost('middlename'); 
				$cdata['last_name'] = $this->request->getPost('lastname'); 
				$cdata['email'] = $this->request->getPost('email'); 
				$cdata['mobile'] = $this->request->getPost('phone'); 
				$cdata['address'] = $this->request->getPost('address'); 
				$cdata['user_id'] = $id; 
				$cdata['status'] = 1;

				$customer = new Customer();
				$customer->insert($cdata);

				$email = new Email();

				$edata['email'] = $cdata['email'];
				$edata['code'] = uniqid(rand(1, 25987));
				$edata['date'] = date('Y-m-d');

				$ev = new \App\Models\EmailVerification();
				$ev->insert($edata);

				$d['link'] = site_url('customer/email-verify?email=' . $edata['email'] . '&code=' . $edata['code']);
				$body = view('templates/email_verification', $d);
				$email->sendMail($edata['email'], 'Email Verification', $body);


				session()->setFlashdata('msg', 'Thank you for registering. An email has been sent to your email address');
				return redirect()->to('customer/register');
			}
			else {
				$data['validator'] = $this->validator;
				return view('customers/register', $data);
			}
		}
		else {
			return view('customers/register', $data);
		}
	}

	public function profile()
	{
		$customer = new Customer();
		$user = new User();

		$user = $user->where(['username' => session()->get('customer')['username']])->first();
		$data = [];
		if($user) {
			$data['customer'] = $customer->where(['user_id' => $user->id])->first();
		}
		return view('customers/profile', $data);
	}

	public function bookings()
	{
		$cus = new Customer();
		$data['customer'] = $cus->where(['email' => session()->get('customer')['email']])->first();

		//dd(session()->get('nurse'));
		$book = new \App\Models\NurseBook();
		$data['bookings'] = $book->getCustomerBookings($data['customer']->id);

		$dbook = new \App\Models\DoctorBooking();
		$data['d_bookings'] = $dbook->getCustomerBookings($data['customer']->id);

		//dd($data['d_bookings']);
		return view('customers/bookings', $data);
	}

	public function logout()
	{	
		session()->remove('customer');
		return redirect('customer/login');
	}

	public function VerifyEmail()
	{
		$email = $this->request->getGet('email');
		$code = $this->request->getGet('code');

		$ev = new \App\Models\EmailVerification();
		$r = $ev->where(['email' => $email, 'code' => $code])->first();

		if($r) {
			$udata['email_verified'] = 1;
			$user = new \App\Models\User();
			$u = $user->where(['email' => $email])->first();
			$user->update($u->id, $udata);
			session()->setFlashdata('msg', 'Your email has been verified');
			return redirect("customer/login");
		}
	}
}