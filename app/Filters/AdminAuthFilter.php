<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface as Request;
use CodeIgniter\HTTP\ResponseInterface as Response;
use CodeIgniter\Filters\FilterInterface;

class AdminAuthFilter implements FilterInterface
{
	public function before(Request $request, $args = null) {
		if(empty(session('admin')) OR session('admin')['user_type'] != 'admin') {
			return redirect('admin/login');
		}
	}


	public function after(Request $request, Response $response, $args = null) {

	}
}