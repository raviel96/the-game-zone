<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller {

    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response) {

        $loginForm = new LoginForm();
        
        if($request->isPost()) {
            $loginForm->loadData($request->getData());
            if($loginForm->validate() && $loginForm->login()) {
                $response->redirect("/");
            }
        }

        return $this->render("login", ['model' => $loginForm]);
    }

    public function register(Request $request, Response $response) {
        
        $user = new User();

        if($request->isPost()) {
            
            $user->loadData($request->getData());

            if($user->validate() && $user->save()) {
                Application::$app->getSession()->setFlash('success', 'Thanks for registering.');
                $response->redirect("/");
            } 

            return $this->render("register", ['model' => $user]);
        }

        return $this->render("register", ['model' => $user]);
    }

    public function logout(Request $request, Response $response) {
        
        Application::$app->logout();

        $response->redirect("/");
    }

    public function profile() {
        return $this->render('profile');
    }
}