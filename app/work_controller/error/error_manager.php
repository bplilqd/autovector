<?php

namespace controller\error;

class error_manager implements interface_error_manager
{
    private static $instance;
    private $errors = [];

    private function __construct()
    {
    }

    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new error_manager();
        }
        return self::$instance;
    }

    public function add_error($error)
    {
        $this->errors[] = $error;
    }

    public function get_errors()
    {
        return $this->errors;
    }

    public function has_errors()
    {
        return !empty($this->errors);
    }
}
