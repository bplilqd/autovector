<?php

namespace model\settings;

class user_config implements interface_user_classe
{
    public function input_data($array)
    {
        $this->set_data($array);
    }
    protected function set_data($array)
    {
        foreach ($array as $name => $value) {
            $this->$name = $value;
        }
    }
}
