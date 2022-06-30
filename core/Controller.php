<?php

namespace app\core;

class Controller
{
	public function render(string $view, array $params = [])
	{
		return Application::$APP->router->renderView($view, $params);
	}

}