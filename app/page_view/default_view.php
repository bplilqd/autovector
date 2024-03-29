<?php

namespace viwe;

class default_view extends viwe{
    public function __construct()
    {
        $this->top = '<h1 class="text-info">Hello world!</h1>';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . 'dark_theme' . DS . 'header.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . 'dark_theme' . DS . 'top.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . 'dark_theme' . DS . 'content.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . 'dark_theme' . DS . 'sidebar.html';
        require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . 'dark_theme' . DS . 'foot.html';
    }
}