<?php
define("TIME_START", microtime(true)); // для вычеслений, внимание - не менять эту строку!

// device of user
$mobile_device_true = false;
if ($_SERVER['HTTP_USER_AGENT']) {
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad') || strstr($_SERVER['HTTP_USER_AGENT'], 'Android') || strstr($_SERVER['HTTP_USER_AGENT'], 'Mobile') || strstr($_SERVER['HTTP_USER_AGENT'], 'Phone') || isset($_GET['mobile'])) {
        $mobile_device_true = true;
    }
}

spl_autoload_register(function ($class_name) {
    // Convert the namespace to a file path
    $file_path = PATH . DS . 'app' . DS . str_replace('\\', DS, $class_name) . '.php';

    // Check if the file exists before connecting
    if (file_exists($file_path)) {
        require_once $file_path;
    } else {
        echo "File $file_path not found:" . __METHOD__;
    }
});

// for settings
require_once PATH . DS . 'app' . DS . 'model' . DS . 'settings' . DS . 'config.php'; // config
require_once PATH . DS . 'app' . DS . 'model' . DS . 'settings' . DS . 'constant.php'; // constant


function Time_sec($t_start, $t_end)
{
    $t = $t_end - $t_start;
    $time_s = round($t, 3);
    return $time_s;
}

function Memory_mb($a)
{
    $a = $a / 1024 / 1024;
    $memory = round($a, 2);
    return $memory;
}
