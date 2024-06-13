<?php

namespace view;

class auth_view extends view implements interface_view, interface_auth
{
    public function __construct()
    {
        $this->start_standart_view();
        $this->setting_properties('title', $this->translations->get_message('auth', 'auth'));
    }

    public function set_meta()
    {
        $meta = '<script src="https://www.google.com/recaptcha/api.js"></script>';
        $this->setting_properties('meta', '', $meta);
    }

    public function include_theme()
    {
        // hard setting of theme
        $this->user_theme = 'design';
        //$this->data_bs_theme = 'light';

        // example structure
        $array = [
            'header',
            'top',
            //            'menu',
            'system_mesage',
            //            'announce',
            'title',
            //            'sidebar',
            'content',
            //'content_without_sidebar',
            'foot'
        ];
        foreach ($array as $value) {
            require_once PATH . DS . 'app' . DS . 'view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
        }
    }
}
