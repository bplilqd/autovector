<?php

namespace view;

class default_view extends view implements interface_set_theme
{
    public function __construct()
    {
        $this->setting_properties('top', 'set', '<a href="/" style="text-decoration: none;"><h1 class="text-info">Hello world!</h1></a>');
        $url_img_autovector = SITE_URL . 'images/autovector.jpg';
        //$url_img_autovector = PATH . DS. 'images/autovector.jpg';
        $this->setting_properties('title', 'set', 'Welcome');
        $this->setting_properties('content', 'set', '<img src="' . $url_img_autovector . '" class="img-fluid" alt="autovector">');
        $this->setting_properties('menu', 'set', '<a href="/app/work_controller/work/auth/index.php"><i class="bi bi-person-square" style="font-size: 2rem;"></i></a>');
    }

    public function set_menu()
    {
            $str = '<a href="/app/work_controller/work/auth/index.php"><i class="bi bi-person-square text-success" style="font-size: 2rem;"></i></a>';
            $this->setting_properties('menu', 'set', $str);
    }

    public function include_theme()
    {
        // example structure
        $array = [
            'header',
            'top',
            'menu',
            'system_mesage',
            //            'announce',
            'title',
            'sidebar',
            'content',
            'foot'
        ];
        foreach ($array as $value) {
            require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
        }
    }
}
