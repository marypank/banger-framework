<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
	public function home()
	{
		$params = [
			'name' => 'Maria',
			'age' => 22,
		];
		return $this->render('home', $params);
	}

	public function contact()
	{
		return $this->render('contact');
	}

	public function handleContact(Request $request)
	{
		$data = $request->getBody();

		/* echo '<pre>';
		var_dump($data);
		echo '</pre>';
		exit; */

		return 'Contact page handling';
	}
}