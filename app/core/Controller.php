<?php
namespace app\core;

use app\core\Application;
use app\core\middlewares\BaseMiddleware;

class Controller {

    public string $layout = "main";
    private string $action = "";

        /**
     * @var BaseMiddleware
     */
    protected array $middlewares = [];

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->getView()->renderView($view, $params);
    }

    public function renderOnlyView($view, $params = []) {
        return Application::$app->getView()->renderOnlyView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware) {
        $this->middlewares[] = $middleware;
    
    }

    public function getAction(): string {
		return $this->action;
	}

    public function setAction($action) {
        $this->action = $action; 
    }

    public function getMiddlewares() {
        return $this->middlewares;
    }
    
}