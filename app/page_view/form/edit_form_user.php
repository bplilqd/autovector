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
        $this->set_form();
        // sent
        return $this->form;
    }

    protected function set_form()
    {
        $date = $this->date;
        $name = $date['edit_form']['name'] ? $date['edit_form']['name'] : $date['data_user']['name'];
        $last_name  = $date['edit_form']['last_name'] ? $date['edit_form']['last_name'] : $date['data_user']['last_name'];
        
        $name_word = $this->translations->get_message('panel_user', 'name');
        $last_name_word = $this->translations->get_message('panel_user', 'last_name');
        $save_name_button = $this->translations->get_message('panel_user', 'save');
        $str = '
      <form>
        <div class="row g-3">
          <div class="col">
            <input type="hidden" name="edit_user">
            <input type="text" name="name" value="' . $name . '" class="form-control" placeholder="' . $name_word . '" aria-label="' . $name_word . '">
          </div>
          <div class="col">
            <input type="text" name="last_name" value="' . $last_name . '" class="form-control" placeholder="' . $last_name_word . '"
              aria-label="' . $last_name_word . '">
          </div>
          <div class="col-12">
            <button type="submit" name="submit_edit" class="btn btn-primary">'.$save_name_button.'</button>
          </div>
        </div>
      </form>';
        $this->form = $str;
    }
}
