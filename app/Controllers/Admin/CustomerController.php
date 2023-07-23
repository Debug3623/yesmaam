<?php
namespace App\Controllers\Admin;

use App\Models\Customer;

class CustomerController extends \App\Controllers\BaseController
{
	public function index()
	{
		$customer = new Customer();
		$data['customers'] = $customer->getCustomers();
		return view('customers/all', $data);
	}

	public function addCustomer()
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

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
				]
			];

			if($this->validate($rules)) {
				$cdata['first_name'] = $this->request->getPost('first_name');
				$cdata['middle_name'] = $this->request->getPost('middle_name');
				$cdata['last_name'] = $this->request->getPost('last_name');
				$cdata['email'] = $this->request->getPost('email');
				$cdata['mobile'] = $this->request->getPost('mobile');
				$cdata['address'] = $this->request->getPost('address');
				$cdata['user_id'] = $this->request->getPost('user_id');
				$cdata['status'] = 1;

				$model = new Customer();
				$model->insert($cdata);

				session()->setFlashdata('msg', 'Customer Added');
				return redirect('admin/customer/add');
			}
			else {
				$data['validator'] = $this->validator;
				return view("customers/add", $data);
			}
		}
		else {
			return view("customers/add", $data);
		}
	}

	public function updateCustomer($id)
	{
		helper(['form']);
		$data['msg'] = session()->getFlashdata('msg');

		$model = new Customer();
		$data['customer'] = $model->where(['id' => DecryptId($id)])->first();

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
				'dob' => [
					'label' => 'Date of Birth',
					'rules' => 'trim|required|valid_date',
				],
				'visa_status' => [
					'label' => 'Visa Status',
					'rules' => 'trim|required',
				],
				'emirates_id' => [
					'label' => 'Emirates ID',
					'rules' => 'trim',
				],
				'emirates_status' => [
					'label' => 'Emirates Status',
					'rules' => 'trim|required',
				],
				'insurance_id' => [
					'label' => 'Insurance ID',
					'rules' => 'trim',
				],
				'insurance_status' => [
					'label' => 'Insurance Status',
					'rules' => 'trim|required',
				],
				'insurance_company' => [
					'label' => 'Insurance Company',
					'rules' => 'trim',
				],
				'nationality' => [
					'label' => 'Nationality',
					'rules' => 'trim|required',
				]
			];

			$photo 		= $this->request->getFile('photo');
			$insurance 	= $this->request->getFile('insurance_pc');
			$emirates 	= $this->request->getFile('emirates_pc');

			//dd($_FILES);
			if($photo && $photo->isValid() && !$photo->hasMoved()) {
				$rules['photo'] = [
					'label' => 'Profile Photo',
					'rules' => 'uploaded[photo]|ext_in[photo,png,jpg,gif,jpeg]'
				];
			}
			if($insurance && $insurance->isValid() && !$insurance->hasMoved()) {
				$rules['insurance_pc'] = [
					'label' => 'Insurance Photo Copy',
					'rules' => 'uploaded[insurance_pc]|ext_in[insurance_pc,png,jpg,gif,jpeg]'
				];
			}
			if($emirates && $emirates->isValid() && !$emirates->hasMoved()) {
				$rules['emirates_pc'] = [
					'label' => 'Emirates Photo Copy',
					'rules' => 'uploaded[emirates_pc]|ext_in[emirates_pc,png,jpg,gif,jpeg]'
				];
			}
			
			//dd($rules);
			if($this->validate($rules)) {
				
				$cdata['first_name'] = $this->request->getPost('first_name');
				$cdata['middle_name'] = $this->request->getPost('middle_name');
				$cdata['last_name'] = $this->request->getPost('last_name');
				$cdata['email'] = $this->request->getPost('email');
				$cdata['mobile'] = $this->request->getPost('mobile');
				$cdata['address'] = $this->request->getPost('address');
				$cdata['insurance_status'] = $this->request->getPost('insurance_status');
				$cdata['emirates_status'] = $this->request->getPost('emirates_status');
				$cdata['dob'] = $this->request->getPost('dob');
				$cdata['visa_status'] = $this->request->getPost('visa_status');
				$cdata['emirates_id'] = $this->request->getPost('emirates_id');
				$cdata['emirates_expiry'] = $this->request->getPost('emirates_expiry');
				$cdata['nationality'] = $this->request->getPost('nationality');
				$cdata['insurance_company'] = $this->request->getPost('insurance_company');
				$cdata['passport_no'] = $this->request->getPost('passport_no');
				$cdata['city'] = $this->request->getPost('city');
				$cdata['insurance_id'] = $this->request->getPost('insurance_id');
				
				if($photo && $photo->isValid() && !$photo->hasMoved())  {
					$loc = './images/customers/';
					$name = $photo->getRandomName();
					if($photo->move($loc, $name)) {
						if(is_file($data['customer']->profile_photo)) {
							if($data['customer']->profile_photo != 'images/male_icon.png' && $data['customer']->profile_photo != 'images/female_icon.png') {
								unlink($data['customer']->profile_photo);
							}
							
						}
						$cdata['profile_photo'] = $loc . $name;
					}
				}
				if($emirates && $emirates->isValid() && !$emirates->hasMoved())  {
					$loc = './images/customers/';
					$name = $emirates->getRandomName();
					if($emirates->move($loc, $name)) {
						if(is_file($data['customer']->emirates_pc)) {
							unlink($data['customer']->emirates_pc);
						}
						$cdata['emirates_pc'] = $loc . $name;
					}
				}
				if($insurance && $insurance->isValid() && !$insurance->hasMoved())  {
					$loc = './images/customers/';
					$name = $insurance->getRandomName();
					if($insurance->move($loc, $name)) {
						if(is_file($data['customer']->insurance_pc)) {
							unlink($data['customer']->insurance_pc);
						}
						$cdata['insurance_pc'] = $loc . $name;
					}
				}
				//dd($cdata);
				//$cdata['user_id'] = $this->request->getPost('user_id');
				$cdata['status'] = 1;

				$model->update(DecryptId($id), $cdata);

				session()->setFlashdata('msg', 'Customer updated');
				return redirect()->to('admin/customer/update/' . $id);
			}
			else {
				//dd($this->validator);
				$data['validator'] = $this->validator;
				return view("customers/update", $data);
			}
		}
		else {
			return view("customers/update", $data);
		}
	}

	public function deleteCustomer($id) {
		$model = new \App\Models\Api\Customer();
		$customer = $model->where(['id' => DecryptId($id)])->first();
		if($customer) {
            $userModel = new \App\Models\Api\User();
            $user = $userModel->where(['id' => $customer->user_id])->first();
            if($user) {
                $userModel->delete($user->id);
            }

			if(is_file($customer->profile_photo)) {
				if($customer->profile_photo != 'images/male_icon.png' && $customer->profile_photo != 'images/female_icon.png') {
					unlink($customer->profile_photo);
				}
			}

			if(is_file($customer->emirates_pc)) {
				unlink($customer->emirates_pc);
			}

			if(is_file($customer->insurance_pc)) {
				unlink($customer->insurance_pc);
			}
			$model->delete($customer->id);
		}
	}

	public function changeStatus($customer_id, $status = 0)
	{
		$customer = new Customer();
		$cus = $customer->where(['id' => DecryptId($customer_id)])->first();
		if($cus) {
			$cdata['status'] = $status;
			$customer->update($cus->id, $cdata);
		}
		
	}

	public function removeUploadedFile()
	{
		//dd(decryptId($this->request->getGet('id')));
		$type = $this->request->getGet('type');
		$loc = urldecode($this->request->getGet('loc'));
		$id = decryptId($this->request->getGet('id'));
		//echo($type . ' ' . $loc . ' ' . $id);
		if(!empty($type) && !empty($loc) && !empty($id)) {
			$model = new Customer();
			$cust = $model->where(['id' => $id])->first();
			if(!$cust) {
				return redirect()->back()->with('remove_err', 'Invalid Customer ID');
			}
			
			if(is_file($loc)) {
				unlink($loc);

				if($type == 'profile') {
					$data['profile_photo'] = '';
				}
				else if($type == 'emirates') {
					$data['emirates_pc'] = '';
				}
				else if($type == 'insurance') {
					$data['insurance_pc'] = '';
				}

				$model->update($id, $data);
				return redirect()->back();
			}
		}
	}
}