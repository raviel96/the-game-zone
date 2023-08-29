<?php

namespace app\controllers;
use app\core\Controller;

class DetailsController extends Controller {
    public function index() {
        return $this->render("details");
    }

    
}