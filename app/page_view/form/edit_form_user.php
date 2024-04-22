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
        $str = '';
        $this->form = $str;
    }
}
