<?php

namespace view;

class user_view extends view implements interface_set_theme
{
    public function __construct()
    {
        $this->top = '<a href="/" style="text-decoration: none;"><h1 class="text-info">Hello world!</h1></a>';
        $this->title = 'User page';
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
