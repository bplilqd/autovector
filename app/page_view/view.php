<?php

namespace view;

use model\function\translations;
use controller\error\error_manager;

class view
{
    protected object $error_manager; // error
    protected object $translations; // lang
    // standart
    private $header = '';
    private $menu = '';
    private $top = '';
    private $system_mesage = '';
    private $announce = '';
    private $title = '';
    private $sidebar = '';
    private $content = ''; // content and also content_without_sidebar
    private $foot = '';
    protected $arr_of_name_propertes = ['top'];
    // extra
    private $meta = '';

    // setting of theme
    public $language = LANGUAGE;
    public $user_theme = DESIGN_THEME;
    public $data_bs_theme = MODE_THEME;

    // main property of this class
    protected function start_standart_view()
    {
        // setting error object
        $this->error_manager = error_manager::get_instance();
        // set object for enter of language
        $this->translations = translations::getInstance();

        // set top
        $this->properties_array('top', ['Hello, World!']);
    }

    // method for setting values ​​as an array for an html template
    public function properties_array($property, $array)
    {
        // array with names for names of methods
        $arr_of_name_propertes = $this->arr_of_name_propertes;
        $namme_function = "set_array_" . $property;

        if (in_array($property, $arr_of_name_propertes)) {
            $html = $this->$namme_function($array);
            $this->setting_properties($property, $html);
        } else {
            $no_such_method_name = $this->translations->get_message(
                'system',
                'no_such_method_name'
            );
            $error = __METHOD__ . ' -> ' . $no_such_method_name . ': 
            ' . $namme_function . '() -> protected $arr_of_name_propertes = [???]';
            $this->error_manager->add_error($error);
        }
    }

    protected function set_array_top($data)
    {
        $html = '<a href="/" style="text-decoration: none;"><h1 class="text-info">' . $data[0] . '</h1></a>';
        return $html;
    }

    // set properties (function in data)
    public function setting_properties($property, $change_or_set_parm = '', $start_parm = '', $end_parm = '')
    {
        $result = '';
        // set
        if ($change_or_set_parm) {
            $result = $change_or_set_parm;
            $this->$property = $result;
        }
        // start
        if ($start_parm) {
            $result = $start_parm . "\n" . $this->$property;
            $this->$property = $result;
        }
        // end
        if ($end_parm) {
            $result = $this->$property . "\n" .  $end_parm . "\n";
            $this->$property = $result;
        }
    }

    // getting_properties (function out data)
    public function getting_properties($property)
    {
        return $this->$property;
    }

    public function set_foot($count_query)
    {
        if (!$count_query) {
            $count_query = 0;
        }
        $str = "
        <center>
        <p> " . $this->translations->get_message(
            'content_page',
            'memory_size'
        ) . ' ' . Memory_mb(memory_get_usage()) . ' '
            . $this->translations->get_message(
                'content_page',
                'mb'
            ) . " <br> 
        " . $this->translations->get_message(
                'content_page',
                'database_queries'
            ) . " " . $count_query . " <br> 
        " . $this->translations->get_message(
                'content_page',
                'execution_time'
            ) . ' ' .  Time_sec(TIME_START, microtime(true))  . ' '
            . $this->translations->get_message(
                'content_page',
                'sec'
            ) . "
        </p>
        </center>";
        $this->foot = $str;
    }

    public function error_print()
    {
        if ($this->error_manager->has_errors()) {
            $result = '';
            foreach ($this->error_manager->get_errors() as $error) {
                $result .= '
                <div class="alert alert-danger" role="alert">
                    ' . $error . '
                </div>
                ';
            }
            $this->system_mesage = $result;
        }
    }
}
