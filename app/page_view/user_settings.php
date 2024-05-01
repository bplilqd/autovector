<?php

namespace view;

class user_settings extends view implements interface_view
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

  public function set_content()
  {
    $data = $this->data_user;
    $content = '
    <div class="row g-3">
    <div class="mb-3">
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
  <label class="form-check-label" for="flexSwitchCheckDefault">Темный режим</label>
</div>
</div>
<div class="mb-3">
<label for="theme_sefault" class="form-label">Тема по умолчанию</label>
<select class="form-select" id="theme_sefault" aria-label="Тема по умолчанию">
  <option selected value="1">design</option>
  <option value="2">theme</option>
</select>
</div>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Сохранить</button>
</div>
</div>';
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
      //'sidebar',
      //'content',
      'content_without_sidebar',
      'foot'
    ];
    foreach ($array as $value) {
      require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'template' . DS . $this->user_theme . DS . $value . '.html';
    }
  }
}
