<?php

use work\default_controller;

$name_model = 'default_model'; // name basic of model

define("PATH", __DIR__); // path to dir site
define("DS", DIRECTORY_SEPARATOR); // builds a file path with the appropriate directory separator
require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'function' . DS . 'function.php';

$main = new default_controller; // set object controller
//print_r("PATH = " . PATH);
print_r($main);
