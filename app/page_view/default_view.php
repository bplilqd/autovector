<?php

namespace viwe;

interface set_theme
{
    public function __construct();
    // print template
    public function include_theme();
}
class default_view extends viwe implements set_theme
{
    public function __construct()
    {
        $this->top = '<h1 class="text-info">Hello world!</h1>';
    }

    public function include_theme()
    {
        // example structure
        $array = [
            'header',
            'menu',
            'top',
            'system_mesage',
            'announce',
            'title',
            'sidebar',
            'content',
            'foot'
        ];
        foreach($array as $value){
            require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . $value.'.html';
        }
    }
}
