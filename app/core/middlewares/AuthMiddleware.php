<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\AccessDeniedException;

class AuthMiddleware extends BaseMiddleware {

    public array $actions = [];

    public function __construct(array $actions = []) {
        $this->actions = $actions;
    }
    
    public function execute() {
        
        if(!Application::isConnected()) {
            if(empty($this->actions) || in_array(Application::$app->getController()->getAction(), $this->actions)) {
                throw new AccessDeniedException();
            }
        }
    }
    
}