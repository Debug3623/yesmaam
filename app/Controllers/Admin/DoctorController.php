<?php
namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use App\Models\Admin\Doctor;

class DoctorController extends \App\Controllers\BaseController
{
	public function index()
	{
		$doc = new Doctor();
		$data['customers'] = $doc->getCustomers();
		return view('doctors/all', $data);
	}
  
  public function confirmDoctor($id)
	{
		$model = new Doctor();
		$doc = $model->where(['id' => DecryptId($id)])->first();
		if($doc) {
			$data['confirmed'] = 1;
			$model->update($doc->id, $data);
		}
	}


	public function addDoctor()
	{
	    
	    
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

		$cate = new Category();
		$data['categories'] = $cate->where(['status' => 1, 'cate_for' => 'doctor'])->findAll();

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
				
				'about_you' => [
					'label' => 'About Nurse',
					'rules' => 'trim|required',
				],
				'specialities' => [
					'label' => 'Specialities',
					'rules' => 'trim|required',
				],
				'category' => [
					'label' => 'Category',
					'rules' => 'trim|required',
				],
				'speaking_languages' => [
					'label' => 'Speaking Languages',
					'rules' => 'trim|required',
				],
				'dob' => [
					'label' => 'Date of Birth',
					'rules' => 'trim|required',
				],
				'password' => [
					'label' => 'Password',
					'rules' => 'trim|required',
				],
				'city' => [
					'label' => 'City',
					'rules' => 'trim|required',
				]
			];

			if($this->request->getPost('password') != '') {
				$rules['password'] = [
					'label' => 'Password',
					'rules' => 'trim|required'
				];
				$rules['password2'] = [
					'label' => 'Re-Type Password',
					'rules' => 'trim|required|matches[password]',
					'errors' => [
						'matches' => 'Password Mismatch'
					]
				];
			}

			$photo = $this->request->getFile('photo');
          	//dd($photo);
			if($photo && $photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]|is_image[photo]'
				];
			}
			
			$doc = $this->request->getFile('medical_licence');
          	//dd($doc);
			if($doc && $doc->isValid() && !$doc->hasMoved()) {
				$rules['medical_licence'] = [
					'label' => 'Medical Licence',
					'rules' => 'uploaded[photo]'
				];
			}

// 			if($this->validate($rules)) {
			    
			    
				$umodel = new \App\Models\Api\User();
				$udata['name'] = $this->request->getPost('first_name');
				$udata['email'] = $this->request->getPost('email');
				$udata['username'] = $this->request->getPost('email');
				$udata['phone'] = $this->request->getPost('mobile');
				$udata['phone_verified'] = $this->request->getPost('phone_verified');
				$udata['email_verified'] = $this->request->getPost('email_verified');

				if($this->request->getPost('password') != '') {
					$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
				}
				
				$udata['user_type'] = 'doctor';
				$udata['status'] = 1;
				$user_id = $umodel->insert($udata);
				

				$cdata['first_name'] = $this->request->getPost('first_name');
				$cdata['middle_name'] = $this->request->getPost('middle_name');
				$cdata['last_name'] = $this->request->getPost('last_name');
				$cdata['email'] = $this->request->getPost('email');
				$cdata['mobile'] = $this->request->getPost('mobile');
				$cdata['address'] = $this->request->getPost('address');
				$cdata['city'] = $this->request->getPost('city');
				$cdata['user_id'] = $user_id;

				$cdata['about_you'] = $this->request->getPost('about_you');
				$cdata['specialities'] = $this->request->getPost('specialities');
				$cdata['category'] = $this->request->getPost('category');
				$cdata['speaking_languages'] = $this->request->getPost('speaking_languages');
				$cdata['dob'] = $this->request->getPost('dob');

			

				if($photo && $photo->isValid() && !$photo->hasMoved()) {
					$name = $photo->getRandomName();
					$loc = 'images/doctors';

					$photo->move($loc, $name);
					$cdata['photo'] = 'images/doctors/' . $name;
				}

				if($doc && $doc->isValid() && !$doc->hasMoved()) {
					$name = $doc->getRandomName();
					$loc = 'documents/doctors';

					$doc->move($loc, $name);
					$cdata['document'] = 'documents/doctors/' . $name;
				}


				$model = new Doctor();
				$model->insert($cdata);

				session()->setFlashdata('msg', 'Doctor Added');
				return redirect()->to('admin/doctor/add');
// 			}
// 			else {
// 				$data['validator'] = $this->validator;
// 				return view("doctors/add", $data);
// 			}
		}
		else {
			return view("doctors/add", $data);
		}
	}

	public function updateDoctor($id)
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

		$cate = new Category();
		$data['categories'] = $cate->where(['status' => 1, 'cate_for' => 'doctor'])->findAll();

		$doc = new Doctor();
		$data['doctor'] = $doc->where(['id' => DecryptId($id)])->first();

		$umodel = new \App\Models\Api\User();
		$user = $umodel->where(['id' => $data['doctor']->user_id])->first();
		$data['user'] = $user;

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
				'city' => [
					'label' => 'City',
					'rules' => 'trim|required',
				],
				
				'about_you' => [
					'label' => 'About Nurse',
					'rules' => 'trim|required',
				],
				'specialities' => [
					'label' => 'Specialities',
					'rules' => 'trim|required',
				],
				'category' => [
					'label' => 'Category',
					'rules' => 'trim|required',
				],
				'speaking_languages' => [
					'label' => 'Speaking Languages',
					'rules' => 'trim|required',
				],
				'dob' => [
					'label' => 'Date of Birth',
					'rules' => 'trim|required',
				],

			];

			if($this->request->getPost('password') != '') {
				$rules['password'] = [
					'label' => 'Password',
					'rules' => 'trim|required'
				];
				$rules['password2'] = [
					'label' => 'Re-Type Password',
					'rules' => 'trim|required|matches[password]',
					'errors' => [
						'matches' => 'Password Mismatch'
					]
				];
			}


			$photo = $this->request->getFile('photo');
			if($photo && $photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]|is_image[photo]'
				];
			}

			$doc = $this->request->getFile('medical_licence');
			if($doc && $doc->isValid() && !$doc->hasMoved()) {
				$rules['document'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]'
				];
			}
			//dd($rules);
			if($this->validate($rules)) {
				
				
				//dd($user);
				$udata['name'] = $this->request->getPost('first_name');
				$udata['email'] = $this->request->getPost('email');
				$udata['username'] = $this->request->getPost('email');
				$udata['phone'] = $this->request->getPost('mobile');
				$udata['phone_verified'] = $this->request->getPost('phone_verified');
				$udata['email_verified'] = $this->request->getPost('email_verified');

				if($this->request->getPost('password') != '') {
					$udata['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT, ['cost' => 12]);
				}
				
				$udata['user_type'] = 'doctor';
				
				$udata['status'] = 1;

				if($user == null && $data['doctor']->user_id == 0) {
					$user_id = $umodel->insert($udata);
				}
				else {
					$umodel->update($user->id, $udata);
					$user_id = $user->id;
				}

				$cdata['first_name'] = $this->request->getPost('first_name');
				$cdata['middle_name'] = $this->request->getPost('middle_name');
				$cdata['last_name'] = $this->request->getPost('last_name');
				$cdata['email'] = $this->request->getPost('email');
				$cdata['mobile'] = $this->request->getPost('mobile');
				$cdata['address'] = $this->request->getPost('address');
				$cdata['city'] = $this->request->getPost('city');
				$cdata['user_id'] = $user_id;

				$cdata['about_you'] = $this->request->getPost('about_you');
				$cdata['specialities'] = $this->request->getPost('specialities');
				$cdata['category'] = $this->request->getPost('category');
				$cdata['speaking_languages'] = $this->request->getPost('speaking_languages');
				$cdata['dob'] = $this->request->getPost('dob');

				//dd($cdata);

				if($photo && $photo->isValid() && !$photo->hasMoved()) {
					$name = $photo->getRandomName();
					$loc = 'images/doctors';

					$photo->move($loc, $name);
					$cdata['photo'] = 'images/doctors/' . $name;

					if(is_file($data['doctor']->photo)) {
						if($data['doctor']->photo != 'images/male_icon.png' && $data['doctor']->photo != 'images/female_icon.png') {
							unlink($data['doctor']->photo);
						}
					}
				}

				if($doc && $doc->isValid() && !$doc->hasMoved()) {
					$name = $doc->getRandomName();
					$loc = 'documents/doctors';

					$doc->move($loc, $name);
					$cdata['document'] = 'documents/doctors/' . $name;

					if(is_file('documents/doctors/' . $data['doctor']->document)) {
						unlink('documents/doctors/' . $data['doctor']->document);
					}
				}

				$cdata['status'] = 1;
				//dd($cdata);
				$model = new Doctor();
				$model->update(DecryptId($id), $cdata);

				session()->setFlashdata('msg', 'Doctor Updated');
				return redirect()->to('admin/doctor/update/' . $id);
			}
			else {
				$data['validator'] = $this->validator;
				//dd($this->validator->getErrors());
				return view("doctors/update", $data);
			}
		}
		else {
			return view("doctors/update", $data);
		}
	}

	public function deleteDoctor($id) {
		$model = new Doctor();
		$doctor = $model->where(['id' => DecryptId($id)])->first();
		if($doctor) {
			$userM = new \App\Models\Api\User();
			$user = $userM->where(['id' => $doctor->user_id])->first();
			if($user) {
				$userM->delete($user->id);
			}

			if(is_file($doctor->photo)) {
				if($doctor->photo != 'images/male_icon.png' && $doctor->photo != 'images/female_icon.png') {
					unlink($doctor->photo);
				}
				
			}

			if(is_file($doctor->document)) {
				unlink($doctor->document);
			}
			$model->delete($doctor->id);
		}
	}

	public function changeAvailability($doctor_id, $status = 0)
	{
		$doctor = new Doctor();
		$doc = $doctor->where(['id' => DecryptId($doctor_id)])->first();
		if($doc) {
			$doctor->update($doc->id, ['available' => $status]);
		}
	}

	public function changeDoctorFor($doctorId)
	{
		$doctorM = new \App\Models\Admin\Doctor();
		$doc = $doctorM->where(['id' => DecryptId($doctorId)])->first();
		if($doc) {
			$doctorM->update($doc->id, [
				'doctor_from' => $this->request->getPost('doctor_from')
			]);
			return "true";
		}
	}
}