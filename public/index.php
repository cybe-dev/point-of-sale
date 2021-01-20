<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../generated-conf/config.php";

use Controller\Auth;
use Cybe\Router;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . "/../.env");

$auth = new Auth();

$router = new Router();

$router->get("/api/auth/login", [[$auth, "login"]]);
$router->get("/api", [
    "Middleware\Authentication::validate",
    function () {
        echo "test";
    },
]);

$router->serve();
