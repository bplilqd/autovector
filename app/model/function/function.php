<?php

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
function do_arr_echo_from_arr($arr, $name, $array_unique = FALSE)
{
    // если нужно убрать повторы
    if ($array_unique) {
        $arr = array_unique($arr);
    }
    // сортировка
    asort($arr);
    $str = '$arr_' . $name . ' = [' . PHP_EOL;
    foreach ($arr as $value) {
        $str .= '\'' . $value . '\',' . PHP_EOL;
    }
    $str .= '];' . PHP_EOL;
    return $str;
}
