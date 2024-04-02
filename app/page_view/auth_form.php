<?php

namespace view;

class auth_form implements interface_auth_form
{
    protected $array;
    protected $form;
    public function input_data($array)
    {
        $this->array = $array;
    }
    public function form()
    {
        $this->set_form();
        return $this->form;
    }
    protected function set_form()
    {
        $str = "form";
        $this->form = $str;
    }
}
