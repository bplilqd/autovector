<?php

namespace view;

class default_view extends view implements interface_view
{
    public function __construct()
    {
        $this->start_standart_view();

        $url_img_autovector = SITE_URL . 'images/autovector.jpg';
        //$url_img_autovector = PATH . DS. 'images/autovector.jpg';

        $this->setting_properties('content', '<img src="' . $url_img_autovector . '" class="img-fluid" alt="autovector">');

        $menu_str = '<a href="' . SITE_URL . 'panel' . DS . 'auth' . DS . '"><i class="bi bi-person-square" style="font-size: 2rem;"></i></a>';
        $this->setting_properties('menu', $menu_str);
    }

    public function set_menu()
    {
        $menu_str = '<a href="' . SITE_URL . 'panel' . DS . 'user' . DS . '"><i class="bi bi-person-square text-success" style="font-size: 2rem;"></i></a>';
        $this->setting_properties('menu', $menu_str);
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
            //'content_without_sidebar',
            'foot'
        ];
        foreach ($array as $value) {
            require_once PATH . DS . 'app' . DS . 'view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
        }
    }
}
