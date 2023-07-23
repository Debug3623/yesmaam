<?php
namespace App\Controllers\Admin;

use App\Models\Api\ServiceBook;
use Automattic\WooCommerce\Client;

class ServicesController extends \App\Controllers\BaseController
{
	public $woocommerce;

	public function __construct()
	{
		$this->woocommerce = new Client('https://yesmaam.ae/', 'ck_e1d984a2ecfff01ff871dc999eeb293f45dff959', 'cs_fbc27437c700af231b8bcd0d92a2a1c0542c2f48', ['version' => 'wc/v3']);
	}

	public function index()
	{
		$model = new ServiceBook();
		$bookings = $model->getServiceBookings();
		
		$this->woocommerce = new Client('https://yesmaam.ae/', 'ck_e1d984a2ecfff01ff871dc999eeb293f45dff959', 'cs_fbc27437c700af231b8bcd0d92a2a1c0542c2f48', ['version' => 'wc/v3']);
		
		$data['bookings'] = [];
		foreach($bookings as $book) {
			$d = [
				'service' => $this->woocommerce->get('products/' . $book->service_id),
				'booking' => $book
			];
			$data['bookings'][] =  $d;
		}
        return view('services/all', $data);
	}

	public function single($id)
	{
		$data['msg'] = session()->getFlashdata('msg');
		$model = new ServiceBook();
		$data['booking'] = $model->getSingleServiceBooking(DecryptId($id));
		$data['service'] = $this->woocommerce->get('products/' . $data['booking']->service_id);

		$data['services'] = $this->woocommerce->get('products');
		//dd($data['service']);
		if($this->request->getMethod() == 'post') {

		}
		else {
			return view('services/edit', $data);
		}
	}

	public function update($id)
	{
		
	}

	public function delete($id)
	{
		
	}
}