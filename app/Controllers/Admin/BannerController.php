<?php
namespace App\Controllers\Admin;

use App\Models\Api\Banner;

class BannerController extends \App\Controllers\BaseController
{
    public function index()
    {
        $banner = new Banner();
        $data['banners'] = $banner->findAll();
        return view('banners/all', $data);
    }

    public function addBanner()
    {
        $data['msg'] = session()->getFlashdata('msg');
        if($this->request->getMethod() == 'post') {
            $rules = [];
            $file = $this->request->getFile('image');
            if($file && $file->isValid() && !$file->hasMoved()) {
                
                $loc = 'images/banners/';
                $name = $file->getRandomName();

                if($file->move($loc, $name)) {
                    $bdata['image'] = $loc.$name;
                    $bdata['href'] = $this->request->getPost('href');
                    $model = new Banner();
                    $model->insert($bdata);

                    session()->setFlashdata('msg', 'Banner Added');
                    return redirect()->to('admin/banner/add');
                }
            }

        }
        else {
            return view('banners/add', $data);
        }
    }

    public function deleteBanner($id)
    {
        $banner = new Banner();
        $b = $banner->where(['id' => DecryptId($id)])->first();
        if($b) {
            if(is_file($b->image)) {
                unlink($b->image);
            }
            $banner->delete($b->id);
        }
    }
}