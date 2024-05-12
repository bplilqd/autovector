<?php

namespace model\function;

interface interface_translations
{
    public static function getInstance();
    public function set_language($language);
    public function get_message($name, $key);
    public function get_language();
}

// Singleton
class translations implements interface_translations
{

    private $language;
    private static $instance;

    // language packs
    protected $auth;
    protected $mysql;
    protected $auth_form;
    protected $panel_user;
    protected $content_page;

    private function __construct()
    {
        $this->language = LANGUAGE;
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

    public function get_language()
    {
        return $this->language;
    }

    public function get_message($name, $key)
    {
        $language = $this->language;
        // If the language is changed, download the package again
        if (!$this->$name) {
            $path = __DIR__ . DS . '..' . DS . '..' . DS . 'view' . DS . 'lang' . DS .$language . DS . $name . '.php';
            $this->$name = include realpath($path);
            //print_r('lang_set ' . $language . ' -> ' . $path . "\n");
        }
        return $this->$name[$key];
    }
}