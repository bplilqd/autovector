<?php

namespace model;

use viwe\default_view;

class default_model extends model
{
    protected $znach_array;
    public function __construct()
    {
        // set objects
        $this->znach_array = new znach_array;
        $this->viwe = new default_view;
    }
}
