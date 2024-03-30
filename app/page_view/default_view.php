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
        $arr = [
            'header',
            'menu',
            'top',
            'system_mesage',
            'announce',
            'title',
            'content',
            'sidebar',
            'foot'
        ];
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'header.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'menu.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'top.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'system_mesage.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'announce.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'title.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'content.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'sidebar.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . 'foot.html';
    }
}
