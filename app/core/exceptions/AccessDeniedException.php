<?php

namespace app\core\exceptions;

class AccessDeniedException extends \Exception{
    
    protected $message = "Accès refusé. Vous n'avez pas les permissions pour accéder à cette ressource.";
    protected $code = 403;
}