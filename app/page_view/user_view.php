<?php

namespace view;

//use model\function\znach_array;

class user_view extends view implements interface_view, interface_user_view
{
  protected $data_user;
  protected $array_info_user_content;

  //protected $znach_array;

  public function __construct()
  {
    // set
    //$this->znach_array = new znach_array;
  
    // start standart
    $this->start_standart_view();
    // data output limitation
    $this->array_info_user_content = [
      'name',
      'last_name',
      'phone',
      'email',
      'date'
    ];
  }

  public function set_menu()
  {
    $array = [
      ['active', '/panel/user/', 'profile'],
      ['', '/panel/user/settings/', 'settings'],
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
<ul class="list-group list-group-flush">';
    $array = $this->array_info_user_content;
    foreach ($data as $key => $value) {
      // if it's on the list
      if ($value && in_array($key, $array)) {
        $content .= '
    <li class="list-group-item">' . $value . '</li>';
      }
    }
    $content .= '
    <li class="list-group-item"><a class="btn btn-secondary" href="?edit_user" role="button">' .
      $this->translations->get_message(
        'panel_user',
        'edit'
      ) . '</a></li>';
    $content .= '
</ul>';
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
