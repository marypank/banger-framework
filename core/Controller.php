<?php

namespace app\core;

class Controller
{
	public string $layout = 'main';

	public function setLayout(string $layout): void
	{
		$this->layout = $layout;
	}

	public function render(string $view, array $params = [])
	{
		return Application::$APP->router->renderView($view, $params);
	}

}