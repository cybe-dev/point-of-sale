<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../generated-conf/config.php";

use Controller\Auth;
use Controller\Product;
use Controller\Supplier;
use Cybe\Router;
use Middleware\BodyGetter;
use Middleware\Validation;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . "/../.env");

$auth = new Auth();
$supplier = new Supplier();
$product = new Product();

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

$router->post("/api/product", [
    "Middleware\Authentication::validate",
    [new Validation($_POST, [
        "name" => "required",
        "price" => "required|numeric",
    ]), "validate"],
    [new BodyGetter, "createPost"],
    [$product, "insert"],
]);
$router->post("/api/product/:id", [
    "Middleware\Authentication::validate",
    [new Validation($_POST, [
        "name" => "required",
        "price" => "required|numeric",
    ]), "validate"],
    [new BodyGetter, "createPost"],
    [$product, "update"],
]);
$router->post("/api/product/delete/:id", [
    "Middleware\Authentication::validate",
    [$product, "delete"],
]);

$router->serve();
