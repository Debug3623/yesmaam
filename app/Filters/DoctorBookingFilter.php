<?php
namespace App\Filters;

use App\Models\User;
use CodeIgniter\HTTP\RequestInterface as Request;
use CodeIgniter\HTTP\ResponseInterface as Response;
use CodeIgniter\Filters\FilterInterface;

class DoctorBookingFilter implements FilterInterface
{
	public function before(Request $request, $args = null) {
		$uri = service('uri');

		session()->set('rurl', current_url());
		session()->set('doctor_id', $uri->getSegment(3));

		$u = session()->get('customer');
		if(!$u) {
			return redirect('customer/login');
		}

		$user = new User();
		$user = $user->where(['username' => $u['username']])->first();

		if(!$user) {
			return redirect('customer/login');
		}
	}


	public function after(Request $request, Response $response, $args = null) {

	}
}