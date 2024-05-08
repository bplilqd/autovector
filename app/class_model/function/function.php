<?php
define("TIME_START", microtime(true)); // для вычеслений, внимание - не менять эту строку!

// device of user
$mobile_device_true = false;
if ($_SERVER['HTTP_USER_AGENT']) {
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad') || strstr($_SERVER['HTTP_USER_AGENT'], 'Android') || strstr($_SERVER['HTTP_USER_AGENT'], 'Mobile') || strstr($_SERVER['HTTP_USER_AGENT'], 'Phone') || isset($_GET['mobile'])) {
        $mobile_device_true = true;
    }
}

// for functions
require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'function' . DS . 'translations.php'; // translations
require_once PATH . DS . 'app' . DS . 'work_controller' . DS . 'error' . DS . 'interface_error_manager.php';
require_once PATH . DS . 'app' . DS . 'work_controller' . DS . 'error' . DS . 'error_manager.php'; // set error
require_once PATH . DS . 'app' . DS . 'page_view' .  DS . 'messages' . DS . 'interfaceMessage.php';
require_once PATH . DS . 'app' . DS . 'page_view' .  DS . 'messages' . DS . 'message.php'; // set for messages
// for settings
require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'settings' . DS . 'config.php'; // config
require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'settings' . DS . 'constant.php'; // constant
// for main class
require_once PATH . DS . 'app' . DS . 'class_model' . DS . 'model.php'; // main model class
require_once PATH . DS . 'app' . DS . 'page_view' . DS . 'view.php'; // main view class
require_once PATH . DS . 'app' . DS . 'work_controller' . DS . 'main_controller.php'; // best main class

// имя текущего класа исполнения/controller, корневого объекта
function set_main_class($name_class)
{
    require_once PATH . DS . 'app' . DS . 'work_controller' . DS . $name_class . '.php'; // controller
}

// функция время выполнения скрипта в  начале, обязательно microtime(true),
// типа так: $time_start = microtime(true);
function Time_sec($t_start, $t_end)
{
    $t = $t_end - $t_start;
    $time_s = round($t, 3);
    return $time_s;
}

// функция вычесления объема требуемой памяти
function Memory_mb($a)
{
    $a = $a / 1024 / 1024;
    $memory = round($a, 2);
    return $memory;
}



// для вывода заголовков и не только
function text_echo($name, $teg_html, $class_text = '')
{
    $result = '<' . $teg_html . ' class="' . $class_text . '">' . $name . '</' . $teg_html . '>';
    return $result;
}

// для падежей
function Padezh($number, $arr)
{
    $arr2 = array(2, 0, 1, 1, 1, 2);
    return $number . ' ' . $arr[($number % 100 > 4 && $number % 100 < 20) ? 2 : $arr2[min($number % 10, 5)]];
}

// вункция выводит одномерный масив в печать/файл иногда это удобно
//function do_arr_echo_from_arr($arr, $name, $array_unique = FALSE) {
//    // если нужно убрать повторы
//    if ($array_unique) {
//        $arr = array_unique($arr);
//    }
//    // сортировка
//    asort($arr);
//    $str = '$arr_' . $name . ' = [' . PHP_EOL;
//    foreach ($arr as $value) {
//        $str .= '\'' . $value . '\',' . PHP_EOL;
//    }
//    $str .= '];' . PHP_EOL;
//    return $str;
//}
