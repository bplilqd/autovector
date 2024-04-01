<?php
namespace model\settings;

interface interface_user_classe
{
    // set data of user from db
    public function input_data($array); 
    // array with data of user
    public function user(); 
}
