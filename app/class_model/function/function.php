<?php

$time_start = microtime(true); // для вычеслений, внимание - не менять эту строку!
// определение девайса
//if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad') || strstr($_SERVER['HTTP_USER_AGENT'], 'Android') || strstr($_SERVER['HTTP_USER_AGENT'], 'Mobile') || strstr($_SERVER['HTTP_USER_AGENT'], 'Phone') || isset($_GET['mobile'])) {
//    $mobile_device_true = true;
//}else{
//    $mobile_device_true = false;
//}

require_once PATH . '/app/class_model/setings/config.php'; // конфиг
require_once PATH . '/app/class_model/setings/constant.php'; // константы


// функция время выполнения скрипта в  начале, обязательно microtime(true),
// типа так: $time_start = microtime(true);
function Time_sec($t_start, $t_end) {
    $time_s = 'Время выполнения ';
    $t = $t_end - $t_start;
    $time_s .= round($t, 3);
    return $time_s .= ' сек.';
}

// функция вычесления объема требуемой памяти
function Memory_mb($a) {
    $memory = 'Объем памяти ';
    $a = $a / 1024 / 1024;
    $memory .= round($a, 2);
    return $memory .= ' mb';
}

// имя текущего класа исполнения, корневого объекта
function set_main_class($type) {
    define("CLASS_NAME", $type); // имя класа $include_main задоное на странице выполнения
    require_once __DIR__ . '/' . $type . '.php';
}

// для вывода заголовков и не только
function text_echo($name, $teg_html, $class_text = '') {
    $result = '<' . $teg_html . ' class="' . $class_text . '">' . $name . '</' . $teg_html . '>';
    return $result;
}

// для падежей
function Padezh($number, $arr) {
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
