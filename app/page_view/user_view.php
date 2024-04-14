<?php

namespace view;

class user_view extends view implements interface_auth_view, interface_user_view
{
    public function __construct()
    {
        $this->setting_properties('top', '<a href="/" style="text-decoration: none;"><h1 class="text-info">Hello world!</h1></a>');
        $this->setting_properties('title', 'User page');
    }

    public function set_menu()
    {
        $menu = '
        <ul class="nav nav-underline">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Профиль</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Настройки</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Выход</a>
          </li>
        </ul>
        ';
        $this->setting_properties('menu', $menu);
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
