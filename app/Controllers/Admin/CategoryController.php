<?php
namespace App\Controllers\Admin;

use App\Models\Category;

class CategoryController extends \App\Controllers\BaseController
{
	public function index()
	{
		$cate = new Category();
		$data['categories'] = $cate->where(['status' => 1])->findAll();

		return view('categories/all', $data);
	}

	public function addCategory()
	{
		$cate = new Category();
		$data['name'] = $this->request->getPost('cname');
		$data['cate_for'] = $this->request->getPost('cfor');
		$data['status'] = 1;

		$cate->insert($data);
		return redirect('admin/category');
	}

	public function deleteCategory($id) 
	{
		$model = new Category();
		$cate = $model->where(['id' => DecryptId($id)])->first();
		//dd($cate);
		if($cate) {
			$model->delete($cate->id);
		}
	}
}