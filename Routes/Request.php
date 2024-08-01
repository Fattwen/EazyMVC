<?php
namespace Routes;

class Request{
    public function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }

        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }

        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
}