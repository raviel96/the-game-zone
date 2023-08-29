<?php

namespace app\core\exceptions;

class NotFoundException extends \Exception {

    protected $message = "Il semblerait que la page demandée n'existe pas.";
    protected $code = 404;
    
}