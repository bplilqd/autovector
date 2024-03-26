<?php

use work\default_controller;

$name_model = 'default_model'; // name basic of model

define("PATH", __DIR__); // path to dir site

require_once PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'class_model' . DIRECTORY_SEPARATOR . 'function' . DIRECTORY_SEPARATOR . 'function.php';
$main = new default_controller; // set object controller
//print_r("PATH = " . PATH);
print_r($main);