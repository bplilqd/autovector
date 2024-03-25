<?php

use work\main_controller;

define("PATH", __DIR__); // path to dir site
require_once PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'class_model' . DIRECTORY_SEPARATOR . 'function' . DIRECTORY_SEPARATOR . 'function.php';

$main = new main_controller;
//print_r("PATH = " . PATH);
print_r($main);