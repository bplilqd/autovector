<?php

namespace view;

class user_settings extends view implements interface_view, interface_user_settings
{
  protected $data_user;

  public function __construct()
  {
    // start standart
    $this->start_standart_view();
  }

  public function set_menu()
  {
    $array = [
      ['', '/panel/user/', 'profile'],
      ['active', '/panel/user/settings/', 'settings'],
      ['', '/panel/user/?logout', 'logout'],
    ];
    $menu = '
        <ul class="nav nav-underline">';

    foreach ($array as $value) {
      $menu .= '
          <li class="nav-item">
            <a class="nav-link ' . $value[0] . '" href="' . $value[1] . '">' . $this->translations->get_message('panel_user', $value[2]) . '</a>
          </li>';
    }

    $menu .= '
        </ul>
        ';
    $this->setting_properties('menu', $menu);
  }

  public function input_data_user($data_user)
  {
    $this->data_user = $data_user;
  }

  public function include_theme()
  {
    // example structure
    $array = [
      'header',
      'top',
      'menu',
      'system_mesage',
      //'announce',
      'title',
      //'sidebar',
      //'content',
      'content_without_sidebar',
      'foot'
    ];
    foreach ($array as $value) {
      require_once PATH . DS . 'app' . DS . 'view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
    }
  }
}
