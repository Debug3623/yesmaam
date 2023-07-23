<?php

namespace App\Filters;

use App\Models\User;
use CodeIgniter\HTTP\RequestInterface as Request;
use CodeIgniter\HTTP\ResponseInterface as Response;
use CodeIgniter\Filters\FilterInterface;


class NurseAuthFilter implements FilterInterface
{
	public function before(Request $request, $args = null) {
		$u = session()->get('nurse');
		if(!$u) {
			return redirect('nurse/login');
		}

		$user = new User();
		$user = $user->where(['username' => $u['username']])->first();

		if(!$user) {
			return redirect('nurse/login');
		}
	}


	public function after(Request $request, Response $response, $args = null) {

	}
}