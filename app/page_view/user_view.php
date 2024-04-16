<?php

namespace view;

class user_view extends view implements interface_auth_view, interface_user_view
{
  protected $data_user;

  public function __construct()
  {
    $this->start_standart_view();
    $this->setting_properties('title', 'User page');
  }

  public function set_menu()
  {
    $menu = '
        <ul class="nav nav-underline">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/panel/user/">Профиль</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?settings">Настройки</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?logout">Выход</a>
          </li>
        </ul>
        ';
    $this->setting_properties('menu', $menu);
  }

  public function set_content()
  {
    $data = $this->data_user;
    $content = '
<ul class="list-group list-group-flush">
';
    foreach ($data as $value) {
      if ($value) {
        $content .= '
    <li class="list-group-item">' . $value . '</li>
    ';
      }
    }
    $content .= '
</ul>
    ';
    $this->setting_properties('content', $content);
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
      'sidebar',
      'content',
      'foot'
    ];
    foreach ($array as $value) {
      require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
    }
  }
}
