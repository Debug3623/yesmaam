<?php
namespace App\Controllers\Front;

use App\Models\User;
use App\Models\Nurse;
use App\Models\NurseBook;

class NurseController extends \App\Controllers\BaseController
{
	public function register() {
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
					'label' => 'Email Address',
					'rules' => 'trim|required|is_unique[nurses.email]|is_unique[users.email]'
				],
				'phone' => [
					'label' => 'Phone',
					'rules' => 'trim|required'
				],
				'password' => [
					'label' => 'Password',
					'rules' => 'trim|required'
				],
				'password2' => [
					'label' => '',
					'rules' => 'trim|required|matches[password]'
				]
			];

			if($this->validate($rules)) {
				//var_dump(new Nurse()); die();
				$ndata['first_name'] = $this->request->getPost('firstname');
				$ndata['middle_name'] = $this->request->getPost('middlename');
				$ndata['last_name'] = $this->request->getPost('lastname');
				$ndata['email'] = $this->request->getPost('email');
				$ndata['phone'] = $this->request->getPost('phone');

				$user = new User();
				$udata['name'] = $this->request->getPost('firstname') .  ' ' . $this->request->getPost('lastname');
				$udata['email'] = $this->request->getPost('email');
				$udata['username'] = $this->request->getPost('email');
				$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
				$udata['user_type'] = 'nurse';
				$udata['status'] = 1;

				$uid = $user->insert($udata);

				$ndata['address'] = $this->request->getPost('address');
				$ndata['user_id'] = $uid;
				$ndata['status'] = 0;
              	$ndata['confirmed'] = 0;

				$nurse = new Nurse();
				$nurse->insert($ndata);

				session()->setFlashdata('msg', 'Thank you for regestring. Please click here to <a href="'. site_url('nurse/login') .'">Login</a> to Complete your profile');

				return redirect()->to('nurse/register');
			}
			else {
				$data['validator'] = $this->validator;
				return view('nurses/register', $data);
			}
		}
		else {
			return view('nurses/register', $data);
		}
	}

	public function login()
	{
		helper('form');
		$data['msg'] = session()->getFlashdata('msg');
		$data['err_msg'] = session()->getFlashdata('err_msg');

		if($this->request->getMethod() == 'post') {
			$rules = [
				'username' => [
					'label' => 'Username',
					'rules' => 'trim|required'
				],
				'password' => [
					'label' => 'Password',
					'rules' => 'trim|required'
				]
			];

			if($this->validate($rules)) {
				$user = new User();
				$nurse = $user->where(['username' => $this->request->getPost('username'), 'user_type' => 'nurse'])->first();

				if(!$nurse) {
					$data['err_msg'] = "User not found.";
					return view('nurses/login', $data);
				}

				if(!password_verify($this->request->getPost('password'), $nurse->password)) {
					$data['err_msg'] = "Username or Password did not match";
					return view('nurses/login', $data);
				}
              
              	


				$this->setUser($nurse);
				return redirect('nurse/profile');
			}
			else {
				$data['validator'] = $this->validator;
				return view('nurses/login', $data);
			}
		}
		else {
			return view('nurses/login', $data);
		}
	}

	public function setUser($user)
	{
		$data['name'] = $user->name;
		$data['username'] = $user->username;
		$data['email'] = $user->email;
		$data['login_time'] = date('Y-m-d H:i:s');
		session()->set('nurse', $data);
	}

	public function profile() {
		$nurse = new Nurse();
		$user = new User();
		
		$user = $user->where(['username' => session()->get('nurse')['username']])->first();
		$data = [];
		if($user) {
			$data['nurse'] = $nurse->where(['user_id' => $user->id])->first();
		}
      	//dd(session()->get());
		return view('nurses/profile', $data);
	}

	public function updateProfile()
	{
		helper('form');

		$nurse = new Nurse();
		$user = new User();
		$category = new \App\Models\Category();
		$data['categories'] = $category->findAll();
		//dd($data['categories']);

		$data['statuses'] = ['married', 'widowed', 'seperated', 'divorced', 'single'];
		$data['visas'] = ['employment', 'business', 'project'];
		$data['work_types'] = ['full_time', 'part_time'];

		$user = $user->where(['username' => session()->get('nurse')['username']])->first();
		if($user) {
			$data['nurse'] = $nurse->where(['user_id' => $user->id])->first();
		}
		
		if($this->request->getMethod() == 'post') {
			//dd($_POST);
			$rules = [
				'first_name' => [
					'label' => 'First Name',
					'rules' => 'trim|required'
				],
				'middle_name' => [
					'label' => 'Middle Name',
					'rules' => 'trim|required'
				],
				'last_name' => [
					'label' => 'Last Name',
					'rules' => 'trim|required'
				],
				'email' => [
					'label' => 'Email ID',
					'rules' => 'trim|required'
				],
				'phone' => [
					'label' => 'Phone',
					'rules' => 'trim|required'
				],
				'work_title' => [
					'label' => 'Work Title',
					'rules' => 'trim|required'
				],
				'expertise' => [
					'label' => 'Expertise',
					'rules' => 'trim|required'
				],
				'about' => [
					'label' => 'About',
					'rules' => 'trim|required'
				],
				'category' => [
					'label' => 'Category',
					'rules' => 'trim|required'
				],
				'working_hours' => [
					'label' => 'Working Hours',
					'rules' => 'trim|required'
				],
				'date_of_birth' => [
					'label' => 'Date of Birth',
					'rules' => 'trim|required'
				],
				'marital_status' => [
					'label' => 'Marital Status',
					'rules' => 'trim|required'
				],
				'skills' => [
					'label' => 'Skills',
					'rules' => 'trim|required'
				],
				'visa_type' => [
					'label' => 'Visa Type',
					'rules' => 'trim|required'
				],
				'city' => [
					'label' => 'City',
					'rules' => 'trim|required'
				],
				'address' => [
					'label' => 'Address',
					'rules' => 'trim|required'
				],
				'working_type' => [
					'label' => 'Working Type',
					'rules' => 'trim|required'
				],
				'experience' => [
					'label' => 'Experience',
					'rules' => 'trim|required'
				],
				'nationality' => [
					'label' => 'Nationality',
					'rules' => 'trim|required'
				],
				'passport_no' => [
					'label' => 'Passport No',
					'rules' => 'trim'
				],
				'eid' => [
					'label' => 'EID',
					'rules' => 'trim'
				]
			];

			$photo = $this->request->getFile('photo');
			if($photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'is_image[photo]|uploaded[photo]'
				];
			}

			$passport = $this->request->getFile('passport');
			if($passport->isValid() && !$passport->hasMoved()) {
				$rules['passport'] = [
					'label' => 'Profile Photo',
					'rules' => 'is_image[passport]|uploaded[passport]'
				];
			}

			if($this->validate($rules)) {
				$ndata['first_name'] = $this->request->getPost('first_name');
				$ndata['middle_name'] = $this->request->getPost('middle_name');
				$ndata['last_name'] = $this->request->getPost('last_name');
				$ndata['email'] = $this->request->getPost('email');
				$ndata['phone'] = $this->request->getPost('phone');
				$ndata['work_title'] = $this->request->getPost('work_title');
				$ndata['about'] = $this->request->getPost('about');
				$ndata['expertise'] = $this->request->getPost('expertise');
				$ndata['category'] = $this->request->getPost('category');
				$ndata['working_hours'] = $this->request->getPost('working_hours');
				$ndata['date_of_birth'] = $this->request->getPost('date_of_birth');
				$ndata['marital_status'] = $this->request->getPost('marital_status');
				$ndata['skills'] = $this->request->getPost('skills');
				$ndata['visa_type'] = $this->request->getPost('visa_type');
				$ndata['experience'] = $this->request->getPost('experience');
				$ndata['nationality'] = $this->request->getPost('nationality');

				$ndata['EID'] = $this->request->getPost('eid');
				$ndata['passport_no'] = $this->request->getPost('passport_no');

				if($photo->isValid() && !$photo->hasMoved()) {
					$name = $photo->getRandomName();
					$loc = 'images/nurses';

					$photo->move($loc, $name);
					$ndata['photo'] = $loc . '/' . $name;
				}

				if($passport->isValid() && !$passport->hasMoved()) {
					$name = $passport->getRandomName();
					$loc = 'images/nurses';

					$passport->move($loc, $name);
					$ndata['passport'] = $loc . '/' . $name;
				}
				
				$ndata['working_type'] = $this->request->getPost('working_type');
				$ndata['city'] = $this->request->getPost('city');
				$ndata['address'] = $this->request->getPost('address');
				$ndata['status'] = 1;

				//dd($ndata);
				$nurse->update($data['nurse']->id, $ndata);

				session()->setFlashdata('msg', 'You account has been Updatd.');
				return redirect()->to('nurse/profile');;
			}
			else {
				$data['validator'] = $this->validator;
				return view('nurses/UpdateProfile', $data);
			}
		}
		else {
			return view('nurses/UpdateProfile', $data);
		}
	}

	public function logout()
	{
		session()->remove('nurse');
		return redirect('nurse/login');
	}

	public function allNurses()
	{
		$where = $this->request->getGet();
		$nurse = new Nurse();
      
      	$cate = new \App\Models\Category();
		$data['categories'] = $cate->where(['cate_for' => 'nurse'])->findAll();

		$w = [];

		if(isset($where['location']) && !empty($where['location'])) {
			$w['city'] = $where['location'];
		}
		
		if(isset($where['work_type']) && !empty($where['work_type'])) {
			$w['working_type'] = $where['work_type'];
			
		}
      
      	if(isset($where['category']) && !empty($where['category'])) {
			$w['category'] = $where['category'];
			
		}

		if($where) {
			$data['nurses'] = $nurse->searchNurses($w);
		}
		else {
			$data['nurses'] = $nurse->getNurses(1);
		}
		//dd($data);
		return view('nurses/all_nurses', $data);
	}

	public function nurseProfile($id) {
		$nurse = new Nurse();
		$data['nurse'] = $nurse->getSingleNurse(DecryptId($id));
      
      	$cate = new \App\Models\Category();
		$data['categories'] = $cate->where(['cate_for' => 'nurse'])->findAll();

		$data['similar_nurses'] = $nurse->getSimilarNurses($data['nurse']->category, $data['nurse']->id);

		return view('nurses/nurse_profile', $data);
	}

	public function yourBookings()
	{
		$nurse = new Nurse();
		$data['nurse'] = $nurse->where(['email' => session()->get('nurse')['email']])->first();

		//dd(session()->get('nurse'));
		$book = new NurseBook();
		$data['bookings'] = $book->getBookings($data['nurse']->id);

		//dd($data['bookings']);
		return view('nurses/bookings', $data);
	}
}