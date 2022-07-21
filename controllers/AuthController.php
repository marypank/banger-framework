<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$this->setLayout('auth');
		return $this->render('login');
	}

	public function register(Request $request)
	{
		$this->setLayout('auth');
		$registerModel = new RegisterModel();
		if ($request->method() === 'post') {
			$registerModel->loadData($request->getBody());

			/* echo '<pre>';
			var_dump($registerModel);
			echo '</pre>';
			exit; */

			if ($registerModel->validate() && $registerModel->register()) {
				return 'Success. You have been registered.';
			}

			return $this->render('register', [
				'model' => $registerModel
			]);
		}
		return $this->render('register', [
			'model' => $registerModel
		]);
	}
}