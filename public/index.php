<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../generated-conf/config.php";

use Controller\Auth;
use Controller\Supplier;
use Cybe\Router;
use Middleware\BodyGetter;
use Middleware\Validation;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . "/../.env");

$validation = new Validation;
$auth = new Auth();
$supplier = new Supplier();

$router = new Router();

$router->get("/api/auth/login", [
    $validation->validate($_GET, [
        "username" => "required",
        "password" => "required",
    ]),
    [$auth, "login"],
]);
$router->post("/api/supplier", [
    $validation->validate($_POST, [
        "name" => "required",
    ]),
    [new BodyGetter, "createPost"],
    [$supplier, "insert"],
]);

$router->serve();
