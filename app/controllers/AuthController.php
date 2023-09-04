<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Login;
use app\models\User;

class AuthController extends Controller {

    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response) {

        $login = new Login();
        
        if($request->isPost()) {
            $login->loadData($request->getData());
            if($login->validate() && $login->login()) {
                $response->redirect("/");
            }
        }

        return $this->renderOnlyView("login", ['model' => $login]);
    }

    public function register(Request $request, Response $response) {
        
        $user = new User();

        if($request->isPost()) {
            
            $user->loadData($request->getData());

            if($user->validate() && $user->save()) {
                Application::$app->getSession()->setFlash('success', 'Thanks for registering.');
                $response->redirect("/");
            } 

            return $this->renderOnlyView("register", ['model' => $user]);
        }

        return $this->renderOnlyView("register", ['model' => $user]);
    }

    public function logout(Request $request, Response $response) {
        
        Application::$app->logout();

        $response->redirect("/");
    }

    public function profile() {
        return $this->render('profile');
    }
}