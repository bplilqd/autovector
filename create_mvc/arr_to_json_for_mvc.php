<?php

namespace create_mvc\array;

class arr_to_json_for_mvc
{
    public $json;
    function __construct($array)
    {
        $json = json_encode($array);
        $this->json = $json;
    }
}
