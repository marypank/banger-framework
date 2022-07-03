<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		return $this->render('login');
	}

	public function register(Request $request)
	{
		if ($request->method() === 'post') {
			return 'handling';
		}
		return $this->render('register');
	}
}