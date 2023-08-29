<?php

namespace app\controllers;
use app\core\Controller;

class SupportController extends Controller{
    public function index() {
       return $this->render("support");
    }

}