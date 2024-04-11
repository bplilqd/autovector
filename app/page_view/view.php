<?php

namespace view;

class view
{
    private $header;
    private $menu;
    private $top;
    private $system_mesage;
    private $announce;
    private $title;
    private $sidebar;
    private $content;
    private $foot;
    private $meta;

    // setting of theme
    public $user_theme = DESIGN_THEME;
    public $data_bs_theme = MODE_THEME;

    // set properties (function in data)
    public function setting_properties($property, $set_option, $change_or_set_parm = '', $start_parm = '', $end_parm = '')
    {
        $result = '';
        if ($set_option == 'set') {
            $result = $change_or_set_parm;
            $this->$property = $result;
        }
        if ($set_option == 'start') {
            $result = $start_parm . $this->$property;
            $this->$property = $result;
        }
        if ($set_option == 'end') {
            $result = $this->$property . $end_parm;
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

        $str = "<center><p> " . Memory_mb(memory_get_usage()) . " <br> Запросов к базе данных " . $count_query . " <br> " . Time_sec(TIME_START, microtime(true)) . "</p></center>";
        $this->foot = $str;
    }

    public function error_print($error_arr)
    {
        if ($error_arr) {
            $result = '';
            foreach ($error_arr as $k => $v) {
                foreach ($v as $val) {
                    $result .= '
                    <div class="alert alert-danger" role="alert">
                        ' . $k . ' -> ' . $val . '
                    </div>
                    ';
                }
            }
            $this->system_mesage = $result;
        }
    }
}
