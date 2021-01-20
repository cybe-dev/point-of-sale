<?php
namespace Controller;

use Model\AdminQuery;
use \Firebase\JWT\JWT;

class Auth
{
    public function login()
    {
        header("Content-Type: application/json");
        $admin = AdminQuery::create()->findOneByUsername($_GET["username"]);
        if ($admin) {
            if (password_verify($_GET["password"], $admin->getPassword())) {
                $payload = [
                    "id" => $admin->getId(),
                    "username" => $admin->getUsername(),
                ];

                $payload = array_merge($payload, [
                    "iat" => time(),
                    "nbf" => time() + 10,
                    "exp" => time() + (((60 * 60) * 24) * 30),
                ]);

                $jwt = JWT::encode($payload, $_ENV["JWT_KEY"]);

                echo json_encode([
                    "id" => $admin->getId(),
                    "username" => $admin->getUsername(),
                    "fullname" => $admin->getFullname(),
                    "email" => $admin->getEmail(),
                    "jwt" => $jwt,
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["error" => "Authentication failed"]);
            }
        }
    }
}
