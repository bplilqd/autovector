<?php

namespace model\function;

interface interface_translations
{
    public static function getInstance();
    public function set_language($language);
    public function get_message($name, $key);
}

// Singleton
class translations implements interface_translations
{

    private $language;
    private static $instance;
    protected $auth;
    protected $mysql;

    private function __construct()
    {
        $this->language = 'en';
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set_language($language)
    {
        $this->language = $language;
    }

    public function get_message($name, $key)
    {
        $language = $this->language;
        if (!$this->$name) {
            $this->$name = include realpath(__DIR__ . '/../../../lang/' . $language . '/' . $name . '.php');
        }
        return $this->$name[$key];
    }
}
