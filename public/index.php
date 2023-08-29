<?php

use app\controllers\AboutController;
use app\controllers\AuthController;
use app\controllers\DetailsController;
use app\controllers\HomeController;
use app\controllers\SupportController;
use app\core\Application;

require_once __DIR__."/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'user' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__)."/app", $config);

$app->getRouter()->get("/", [HomeController::class, "index"]);
$app->getRouter()->get("/support", [SupportController::class, "index"]);
$app->getRouter()->post("/support", [SupportController::class, "index"]);
$app->getRouter()->get("/about", [AboutController::class, "index"]);
$app->getRouter()->get("/details", [DetailsController::class, "index"]);

$app->getRouter()->get('/login', [AuthController::class, "login"]);
$app->getRouter()->post('/login', [AuthController::class, "login"]);
$app->getRouter()->get('/register', [AuthController::class, "register"]);
$app->getRouter()->post('/register', [AuthController::class, "register"]);
$app->getRouter()->get('/logout', [AuthController::class, "logout"]);
$app->getRouter()->get('/profile', [AuthController::class, "profile"]);

$app->run();