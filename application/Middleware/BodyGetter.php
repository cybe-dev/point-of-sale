<?php
namespace Middleware;

class BodyGetter
{
    private function getter($input)
    {
        if ($input == "get") {
            return function ($key) {if (isset($_GET[$key])) {
                return $_GET[$key];
            } else {
                return "";
            }};
        } else {
            return function ($key) {if (isset($_POST[$key])) {
                return $_POST[$key];
            } else {
                return "";
            }};
        }
    }

    public function createGet($param, $position, $next)
    {
        $param["getter"] = $this->getter("get");

        $next($param, $position);
    }

    public function createPost($param, $position, $next)
    {
        $param["getter"] = $this->getter("post");

        $next($param, $position);
    }
}
