<?php
namespace App\Controllers\Front;

use App\Models\Category;
use App\Models\Doctor;

class DoctorController extends \App\Controllers\BaseController
{
	public function register()
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

		if($this->request->getMethod() == 'post') {
			$rules = [
				"firstname" => [
					'label' => 'First Name',
					'rules' => 'trim|required'
				],
				"middlename" => [
					'label' => 'Middle Name',
					'rules' => 'trim|required'
				],
				"lastname" => [
					'label' => 'Last Name',
					'rules' => 'trim|required'
				],
				"dob" => [
					'label' => 'Date of Birth',
					'rules' => 'trim|required'
				],
				"address" => [
					'label' => 'Address',
					'rules' => 'trim|required'
				],
				"email" => [
					'label' => 'Email Address',
					'rules' => 'trim|required'
				],
				"aboutyou" => [
					'label' => 'About You',
					'rules' => 'trim|required'
				],
				"specialities" => [
					'label' => 'Specialities',
					'rules' => 'trim|required'
				],
				"category" => [
					'label' => 'Category',
					'rules' => 'trim|required'
				],
				"terms" => [
					'label' => 'Terms & Conditions',
					'rules' => 'trim|required'
				]
			];

			$photo = $this->request->getFile('photo');
			//dd($photo);
			if($photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]|is_image[photo]'
				];
			}

			if($this->validate($rules)) {
				$ddata['first_name'] = $this->request->getPost('firstname');
				$ddata['middle_name'] = $this->request->getPost('middlename');
				$ddata['last_name'] = $this->request->getPost('lastname');
				$ddata['dob'] = $this->request->getPost('dob');
				$ddata['address'] = $this->request->getPost('address');
				$ddata['email'] = $this->request->getPost('email');
				$ddata['about_you'] = $this->request->getPost('aboutyou');
				$ddata['specialities'] = $this->request->getPost('specialities');
				$ddata['category'] = $this->request->getPost('category');
				$ddata['speaking_languages'] = $this->request->getPost('languages');

				$filename = $photo->getRandomName();
				$loc = 'images/doctors/';
				if($photo->move($loc, $filename)) {
					$ddata['photo'] = 'images/doctors/' . $filename;
				}
				
				$ddata['status'] = 1;

				//dd($ddata);
				$doc = new Doctor();
				$doc->insert($ddata);
				session()->setFlashdata('msg', 'Thank you for registering to our website. We will be in touch with you');
				return redirect()->to('doctor/register');
			}
			else {
				$data['validator'] = $this->validator;
				return view('doctors/register', $data);
			}
		}
		else {
			return view('doctors/register', $data);
		}
	}

	public function doctorProfile($id) {
		$nurse = new Doctor();
		$data['doctor'] = $nurse->getSingleDoctor(DecryptId($id));
		$data['speciality'] = ['Orthopedics', 'Internal Medicine', 'Obstetrics and Gynecology', 'Dermatology', 'Radiology'];
      
		$cate = new Category();
		$data['categories'] = $cate->where(['status' => 1, 'cate_for' => 'doctor'])->findAll();

		$data['similar_doctors'] = $nurse->getSimilarDoctors($data['doctor']->category, $data['doctor']->id);

		return view('doctors/doctor_profile', $data);
	}

	public function allDoctors()
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
			$data['nurses'] = $doc->getDoctors(1);
		}
		//dd($data);
		return view('doctors/all_doctors', $data);
	}
}