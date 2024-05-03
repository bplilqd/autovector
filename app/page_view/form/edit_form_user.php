<?php

namespace view\form;

use model\function\translations;

class edit_form_user extends form implements interface_form
{

  public function form($date)
  {
    // set object for enter of language
    $this->translations = translations::getInstance();
    // data
    $this->date = $date;
    // set
    $this->option_setting_form();
    // sent
    return $this->form;
  }

  protected function set_form($name, $name_word, $last_name, $last_name_word, $save_name_button)
  {
    $str = '
      <form method="POST">
        <div class="row g-3">
          <div class="mb-3">
            <input type="hidden" name="edit_user">
            <input type="text" name="name" value="' . $name . '" class="form-control" placeholder="' . $name_word . '" aria-label="' . $name_word . '">
          </div>
          <div class="mb-3">
            <input type="text" name="last_name" value="' . $last_name . '" class="form-control" placeholder="' . $last_name_word . '"
              aria-label="' . $last_name_word . '">
          </div>
          <div class="mb-3">
            <button type="submit" name="submit_edit" class="btn btn-primary">' . $save_name_button . '</button>
            </div>
        </div>
      </form>';
    $this->form = $str;
  }

  private function option_setting_form()
  {
    $date = $this->date;

    $edit_form_name = '';
    $edit_form_last_name = '';
    $data_user_name = '';
    $data_user_last_name = '';

    if ($date['edit_form']) {
      $edit_form_name = $date['edit_form']['name'];
      $edit_form_last_name = $date['edit_form']['last_name'];
    }

    if ($date['data_user']) {
      $data_user_name = $date['data_user']['name'];
      $data_user_last_name = $date['data_user']['last_name'];
    }

    $name = $edit_form_name ? $edit_form_name : $data_user_name;
    $last_name  = $edit_form_last_name ? $edit_form_last_name : $data_user_last_name;

    $name_word = $this->translations->get_message('panel_user', 'name');
    $last_name_word = $this->translations->get_message('panel_user', 'last_name');
    $save_name_button = $this->translations->get_message('panel_user', 'save');
    
    $this->set_form($name, $name_word, $last_name, $last_name_word, $save_name_button);
  }
}
