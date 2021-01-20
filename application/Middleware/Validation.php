<?php
namespace Middleware;

use Rakit\Validation\Validator;

class Validation
{
    private $validation;

    public function validate($input, $rules)
    {
        $validator = new Validator;
        $this->validation = $validator->validate($input, $rules);
        return function ($param, $position, $next) {
            if ($this->validation->fails()) {
                header("Content-Type: application/json");
                http_response_code(400);
                echo json_encode($this->validation->errors()->toArray());
            } else {
                $next($param, $position);
            }
        };
    }
}
