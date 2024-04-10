<?php

namespace view;

class view
{
    public $header;
    public $menu;
    public $top;
    public $system_mesage;
    public $announce;
    public $title;
    public $sidebar;
    public $content;
    public $foot;
    public $meta;

    // setting of theme
    public $user_theme = DESIGN_THEME;
    public $data_bs_theme = MODE_THEME;

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
