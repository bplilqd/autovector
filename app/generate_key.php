<?php

include_once __DIR__ . '/model/function/generateCustomKey.php';

use function model\function\generateCustomKey;

// Пример использования для генерации ключа длиной 32 символа
$key = generateCustomKey();
echo $key;
// Пример вывода: GFGl4756hdkcnfDSFTO4793dhf454kkK