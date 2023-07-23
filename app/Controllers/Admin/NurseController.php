<?php
namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\Nurse;
use App\Models\Category;

class NurseController extends \App\Controllers\BaseController
{
	public function index()
	{
		$customer = new Nurse();
		$data['nurses'] = $customer->getNurses();
		return view('nurses/all', $data);
	}

	public function addNurse()
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

		$cate = new Category();
		$cate1 = $cate->where(['status' => 1, 'cate_for' => 'nurse'])->findAll();
		$cate2 =  $cate->where(['status' => 1, 'cate_for' => 'babysitter'])->findAll();
		$data['categories'] = array_merge($cate1, $cate2);

		$data['statuses'] = ['married', 'widowed', 'seperated', 'divorced', 'single'];
		$data['visas'] = ['employment', 'business', 'project'];
		$data['work_types'] = ['full_time', 'part_time'];

		if($this->request->getMethod() == 'post') {
			

			$rules = [
				'first_name' => [
					'label' => 'First Name',
					'rules' => 'trim|required',
				],
				'middle_name' => [
					'label' => 'Middle Name',
					'rules' => 'trim',
				],
				'last_name' => [
					'label' => 'Last Name',
					'rules' => 'trim',
				],
				'email' => [
					'label' => 'Email Address',
					'rules' => 'trim|required',
				],
				'mobile' => [
					'label' => 'Mobile no.',
					'rules' => 'trim|required',
				],
				'address' => [
					'label' => 'Address',
					'rules' => 'trim|required',
				],
				'work_title' => [
					'label' => 'Work Title',
					'rules' => 'trim|required',
				],
				'about' => [
					'label' => 'About Nurse',
					'rules' => 'trim|required',
				],
				'expertise' => [
					'label' => 'Expertise',
					'rules' => 'trim|required',
				],
				'category' => [
					'label' => 'Category',
					'rules' => 'trim|required',
				],
				'working_hours' => [
					'label' => 'Workinh Hours',
					'rules' => 'trim|required',
				],
				'date_of_birth' => [
					'label' => 'Date of Birth',
					'rules' => 'trim|required',
				],
				'marital_status' => [
					'label' => 'Marital Status',
					'rules' => 'trim|required',
				],
				'skills' => [
					'label' => 'Skills',
					'rules' => 'trim|required',
				],
				'visa_type' => [
					'label' => 'Visa Type',
					'rules' => 'trim|required',
				],
				'working_type' => [
					'label' => 'Work Type',
					'rules' => 'trim|required',
				],
				'city' => [
					'label' => 'City',
					'rules' => 'trim|required',
				],
				'nationality' => [
					'label' => 'Nationality',
					'rules' => 'trim|required',
				],
				'experience' => [
					'label' => 'Experience',
					'rules' => 'trim|required',
				],
				'password' => [
					'label' => 'Password',
					'rules' => 'trim|required',
				],
				'passport_no' => [
					'label' => 'Passport No',
					'rules' => 'trim',
				],
				'eid' => [
					'label' => 'EID',
					'rules' => 'trim',
				]
			];

			$photo = $this->request->getFile('photo');
          	//dd($photo);
			if(isset($photo) && $photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]|is_image[photo]'
				];
			}

			$passport = $this->request->getFile('passport');
			if(isset($passport) && $passport->isValid() && !$passport->hasMoved()) {
				$rules['passport'] = [
					'label' => 'Passport',
					'rules' => 'uploaded[passport]|is_image[passport]'
				];
			}

			if($this->validate($rules)) {
				

				$cdata['first_name'] = $this->request->getPost('first_name');
				$cdata['middle_name'] = $this->request->getPost('middle_name');
				$cdata['last_name'] = $this->request->getPost('last_name');
				$cdata['email'] = $this->request->getPost('email');
				$cdata['phone'] = $this->request->getPost('mobile');
				$cdata['address'] = $this->request->getPost('address');
				$cdata['work_title'] = $this->request->getPost('work_title');
				$cdata['about'] = $this->request->getPost('about');
				$cdata['expertise'] = $this->request->getPost('expertise');
				$cdata['category'] = $this->request->getPost('category');
				$cdata['working_hours'] = $this->request->getPost('working_hours');
				$cdata['date_of_birth'] = $this->request->getPost('date_of_birth');
				$cdata['marital_status'] = $this->request->getPost('marital_status');
				$cdata['skills'] = $this->request->getPost('skills');
				$cdata['visa_type'] = $this->request->getPost('visa_type');
				$cdata['experience'] = $this->request->getPost('experience');
				$cdata['nationality'] = $this->request->getPost('nationality');
				$cdata['passport_no'] = $this->request->getPost('passport_no');
				$cdata['EID'] = $this->request->getPost('eid');
				//dd($cdata);

				if(isset($photo) && $photo->isValid() && !$photo->hasMoved()) {
					$name = $photo->getRandomName();
					$loc = 'images/nurses';

					$photo->move($loc, $name);
					$cdata['photo'] = 'images/nurses/' . $name;
				}

				if(isset($passport) && $passport->isValid() && !$passport->hasMoved()) {
					$name = $passport->getRandomName();
					$loc = 'images/nurses';

					$passport->move($loc, $name);
					$cdata['passport'] = 'images/nurses/' . $name;
				}
				
				$cdata['working_type'] = $this->request->getPost('working_type');
				$cdata['city'] = $this->request->getPost('city');


				$udata['name'] = $cdata['first_name'] . ' ' . $cdata['last_name'];
				$udata['email'] = $cdata['email'];
				$udata['username'] = $cdata['email'];
				$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
				$udata['user_type'] = 'nurse';
				$udata['status'] = 1;

				$user = new User();
				$uid = $user->insert($udata);




				$cdata['user_id'] = $uid;
				$cdata['status'] = 1;

				$model = new Nurse();
				$model->insert($cdata);

				session()->setFlashdata('msg', 'Nurse Added');
				return redirect()->to('admin/nurse/add');
			}
			else {
				$data['validator'] = $this->validator;
				return view("nurses/add", $data);
			}
		}
		else {
			return view("nurses/add", $data);
		}
	}

	public function updateNurse($id)
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

		$nurse = new Nurse();
		$data['nurse'] = $nurse->where(['id' => DecryptId($id)])->first();

		$cate = new Category();
		$cate1 = $cate->where(['status' => 1, 'cate_for' => 'nurse'])->findAll();
		$cate2 =  $cate->where(['status' => 1, 'cate_for' => 'babysitter'])->findAll();
		$data['categories'] = array_merge($cate1, $cate2);

		$data['statuses'] = ['married', 'widowed', 'seperated', 'divorced', 'single'];
		$data['visas'] = ['employment', 'business', 'project'];
		$data['work_types'] = ['full_time', 'part_time'];

		if($this->request->getMethod() == 'post') {
			
			

			$photo = $this->request->getFile('photo');
			if(isset($photo) && $photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]|is_image[photo]'
				];
			}

			$passport = $this->request->getFile('passport');
			if(isset($passport) && $passport->isValid() && !$passport->hasMoved()) {
				$rules['passport'] = [
					'label' => 'Passport',
					'rules' => 'uploaded[passport]|is_image[passport]'
				];
			}

			if($this->validate('nurse_update')) {
				
				$cdata['first_name'] = $this->request->getPost('first_name');
				$cdata['middle_name'] = $this->request->getPost('middle_name');
				$cdata['last_name'] = $this->request->getPost('last_name');
				$cdata['email'] = $this->request->getPost('email');
				$cdata['phone'] = $this->request->getPost('mobile');
				$cdata['address'] = $this->request->getPost('address');
				$cdata['work_title'] = $this->request->getPost('work_title');
				$cdata['about'] = $this->request->getPost('about');
				$cdata['expertise'] = $this->request->getPost('expertise');
				$cdata['category'] = $this->request->getPost('category');
				$cdata['working_hours'] = $this->request->getPost('working_hours');
				$cdata['date_of_birth'] = $this->request->getPost('date_of_birth');
				$cdata['marital_status'] = $this->request->getPost('marital_status');
				$cdata['skills'] = $this->request->getPost('skills');
				$cdata['visa_type'] = $this->request->getPost('visa_type');
				$cdata['experience'] = $this->request->getPost('experience');
				$cdata['nationality'] = $this->request->getPost('nationality');
              	$cdata['passport'] = $this->request->getPost('passport');
				$cdata['EID'] = $this->request->getPost('eid');
				
				if(isset($photo) && $photo->isValid() && !$photo->hasMoved()) {
					$name = $photo->getRandomName();
					$loc = 'images/nurses';
					if(is_file($data['nurse']->photo)) {
						if($data['nurse']->photo != 'images/male_icon.png' && $data['nurse']->photo != 'images/female_icon.png') {
							unlink($data['nurse']->photo);
						}
					}
					$photo->move($loc, $name);
					$cdata['photo'] = 'images/nurses/' . $name;
				}

				if(isset($passport) && $passport->isValid() && !$passport->hasMoved()) {
					$name = $passport->getRandomName();
					$loc = 'images/nurses';
					if(is_file($data['nurse']->passport)) {
						unlink($data['nurse']->passport);
					}
					$passport->move($loc, $name);
					$cdata['passport'] = 'images/nurses/' . $name;
				}
				
				$cdata['working_type'] = $this->request->getPost('working_type');
				$cdata['city'] = $this->request->getPost('city');
				$udata['name'] = $cdata['first_name'] . ' ' . $cdata['last_name'];
				$udata['email'] = $cdata['email'];
				$udata['username'] = $cdata['email'];

				if($this->request->getPost('password') != '') {
					$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
				}
				
				$udata['user_type'] = 'nurse';
				$udata['status'] = 1;

				$user = new User();
				$user->update($data['nurse']->user_id, $udata);


				$cdata['user_id'] = $data['nurse']->user_id;
				$cdata['status'] = 1;

				$model = new Nurse();
				$model->update(DecryptId($id), $cdata);

				session()->setFlashdata('msg', 'Nurse Updated');
				return redirect()->to('admin/nurse/update/' . $id);
			}
			else {
				$data['validator'] = $this->validator;
				return view("nurses/update", $data);
			}
		}
		else {
			return view("nurses/update", $data);
		}
	}

	public function deleteNurse($id) {
		$model = new Nurse();
		$nurse = $model->where(['id' => DecryptId($id)])->first();

		$umodel = new \App\Models\Api\User();
		$user = $umodel->where(['id' => $nurse->user_id])->first();
		if($nurse) {
			if($user) {
				$umodel->delete($user->id);
			}
			if(is_file($nurse->photo)) {
				if($nurse->photo != 'images/male_icon.png' && $nurse->photo != 'images/female_icon.png') {
					unlink($nurse->photo);
				}
			}

			if(is_file($nurse->passport)) {
				unlink($nurse->passport);
			}
			$model->delete($nurse->id);
		}
	}
  
  	public function confirmNurse($id)
    {
    	$data['confirmed'] = 1;
      	$nurse = new Nurse();
      	$n = $nurse->where(['id' => DecryptId($id)])->first();
      	if($n) {
        	$nurse->update(DecryptId($id), $data);
          	return true;
        }
      	return false;
    }

	public function changeStatus($nurse_id, $status = 0)
	{
		$nurse = new \App\Models\Api\Nurse();
		$cus = $nurse->where(['id' => DecryptId($nurse_id)])->first();
		if($cus) {
			$cdata['status'] = $status;
			$nurse->update($cus->id, ['available' => $status]);
		}
	}
	
	public function changeAvailability()
	{
	    $nurse_id = $this->request->getPost('nurse_id');
	    $status = $this->request->getPost('status');
	    //die($status);
	    $nurseM = new \App\Models\Api\Nurse();
		$nurse = $nurseM->where(['id' => DecryptId($nurse_id)])->first();
		//dd($nurse);
		if($nurse) {
			$nurseM->update($nurse->id, [
			    'available' => $status
			]);
			//return redirect('admin/nurse');
		}
	}
	
	
	

	public function changeNurseFor($nurseId)
	{
		$nurseM = new \App\Models\Admin\Nurse();
		$nurse = $nurseM->where(['id' => DecryptId($nurseId)])->first();
		if($nurse) {
			$nurseM->update($nurse->id, [
				'nurse_from' => $this->request->getPost('nurse_from')
			]);
			return "true";
		}
	}
}
