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

$auth = new Auth();
$supplier = new Supplier();

$router = new Router();

$router->get("/api/auth/login", [
    [new Validation($_GET, [
        "username" => "required",
        "password" => "required",
    ]), "validate"],
    [$auth, "login"],
]);
$router->post("/api/supplier", [
    "Middleware\Authentication::validate",
    [new Validation($_POST, [
        "name" => "required",
        "phone" => "numeric",
    ]), "validate"],
    [new BodyGetter, "createPost"],
    [$supplier, "insert"],
]);
$router->post("/api/supplier/:id", [
    "Middleware\Authentication::validate",
    [new Validation($_POST, [
        "name" => "required",
        "phone" => "numeric",
    ]), "validate"],
    [new BodyGetter, "createPost"],
    [$supplier, "update"],
]);
$router->post("/api/supplier/delete/:id", [
    "Middleware\Authentication::validate",
    [$supplier, "delete"],
]);

$router->serve();
