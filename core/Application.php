<?php

namespace app\core;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;

    public static Application $APP;
    public static string $ROOT_DIR;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$APP = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

	public function getController()
	{
		return $this->controller;
	}

	public function setController(Controller $controller): void
	{
		$this->controller = $controller;
	}
}
