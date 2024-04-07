<?php

namespace view;

class auth_view extends view implements interface_set_theme
{
    public function __construct()
    {
        $this->top = '<h1 class="text-info">Hello world!</h1>';
        $this->title = 'Авторизация';
    }

    public function include_theme()
    {
        // setting of theme
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
            'foot'
        ];
        foreach ($array as $value) {
            require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
        }
    }
}
