<?php

namespace work;

use model\model;
use viwe\viwe;

class main_controller
{
    protected $viwe;
    protected $model;

    function __construct()
    {
        $this->viwe = new viwe;
        $this->model = new model;
    }
}
