<?php
namespace Middleware;

use \Firebase\JWT\JWT as JwtLib;

class Authentication
{
    public static function validate($param, $position, $next)
    {
        $headers = apache_request_headers();
        $decoded = [];
        if (!isset($headers["Authorization"])) {
            http_response_code(401);
            echo json_encode([
                "errors" => "Unauthorize",
            ]);
            return;
        }

        $authorization = explode(" ", $headers["Authorization"]);

        if ($authorization[0] != "Bearer") {
            http_response_code(401);
            echo json_encode([
                "errors" => "Unauthorize",
            ]);
            return;
        }

        $jwt = $authorization[1];
        $key = $_ENV["JWT_KEY"];

        try {
            $decoded = JwtLib::decode($jwt, $key, ["HS256"]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([
                "errors" => "Unauthorize",
            ]);
            return;
        }

        $next(array_merge($param, [
            "admin" => $decoded,
        ]), $position);
    }
}
