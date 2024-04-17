<?php

namespace view;

class not_authorized_view extends view implements interface_auth_view
{
    public function __construct()
    {
        $this->start_standart_view();
        $this->setting_properties('title', 'You not authorized');
    }

    public function include_theme()
    {
        // example structure
        $array = [
            'header',
            'top',
            // 'menu',
            'system_mesage',
            //            'announce',
            'title',
            //'sidebar',
            //'content',
            //'content_without_sidebar',
            'foot'
        ];
        foreach ($array as $value) {
            require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
        }
    }
}
