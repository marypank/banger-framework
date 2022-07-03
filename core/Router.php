<?php

namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        /*
        it can take
            1. a function
            2. a string to render view
            3. a class and a method in this class
        	4. and data (post, get, ect)
         */
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }

        if (is_string($callback)) {
            $this->renderView($callback);
        }

        if (is_array($callback)) {
			$callback[0] = new $callback[0]();
		}

        return call_user_func($callback, $this->request);
    }

    public function renderView($view, array $params = [])
    {
        // todo: user can create many folders with many views, so layouts too (make this)
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    private function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    private function renderOnlyView($view, array $params)
    {
    	foreach ($params as $key => $value) {
    		$$key = $value; // if $key = 'name' or 'post_id' or smth like that, $$ means that $key now $name/$post_id/$smth and it can be shown in a template
		}

        ob_start();
        include_once Application::$ROOT_DIR."/views/{$view}.php";
        return ob_get_clean();
    }
}
