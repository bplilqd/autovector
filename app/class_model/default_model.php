<?php

namespace model;

use viwe\default_view;

class default_model extends model
{
    public function __construct()
    {
        // set objects
        $this->viwe = new default_view;
    }
}
