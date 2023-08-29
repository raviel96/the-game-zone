<?php
namespace app\core;
use app\core\exceptions\AccessDeniedException;
use app\core\exceptions\NotFoundException;
use app\core\Request;

class Router {

    protected array $routes = [];

    protected array $forbiddenRoutes = [];
    public Request $request;
    public Response $response;
    
    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;

        $this->forbiddenRoutes = ["/css/", "/js/", "/img/"];
    }
    
    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve() {
        // On récupère le path et la méthode
        // Ensuite on vérifie si la route existe
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if(in_array($path, $this->forbiddenRoutes)) {
            throw new AccessDeniedException();
        }

        // Si la route demandé n'exite pas, on affiche une page d'erreur
        if(!$callback) {
            throw new NotFoundException();
        }

        // Ici on regarde si la route demandé est une string
        // Si oui, alors on renvoie directement la vue
        if(is_string($callback)) return Application::$app->getView()->renderView($callback);

        // On sait que le callback est un tableau
        // On cree une nouvelle instance du controller qui se trouve à la position 0
        if(is_array($callback)){
            $callback[0] = new $callback[0];
            Application::$app->setController($callback[0]);
            Application::$app->getController()->setAction($callback[1]); 
        }


        return call_user_func($callback, $this->request, $this->response);
    } 
}