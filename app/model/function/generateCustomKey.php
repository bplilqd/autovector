<?php

namespace model\function;

function generateCustomKey($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        // random_int() генерирует криптографически безопасное случайное целое число
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}