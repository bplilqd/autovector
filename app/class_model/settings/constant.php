<?php

namespace constantMain;

// подклечение базы данных
define("HOST_DB", $host_db); // хост
define("USER_DB", $user_db); // пользователь
define("NAME_DB", $name_db); // имя базы данных
define("PASS_DB", $pass_db); // пароль пользователя базы данных

// for set theme
define("DESIGN_THEME", 'theme'); // theme default
define("MODE_THEME", 'dark'); // mode default

// system
define("NAME_MODEL", $name_model); // name basic of model
define("NAME_CONTROLLER", $name_controller); // name basic of controller
define("NAME_VIEW", $name_view); // name basic ofview / NAME_VIEW

// служебные
define("USER_HASH", $_COOKIE['hash']); // hash
define("IP", $_SERVER['REMOTE_ADDR']); // ip адрес пользователя
define("HOST", $_SERVER['SERVER_NAME']); // имя сайта
define("REFERER", $_SERVER['HTTP_REFERER']); // реф ссылка
define("HTTP_HTTPS", $http_or_https); // протокол по умолчанию например https://
define("SITE_URL", HTTP_HTTPS . HOST . DS);
define("MOBILE_DEVICE", $mobile_device_true);
define("SECRET_KEY", $secret_key); // секретный ключ для генерации md5
define("SET_COOK_TIME_HASH", $set_cook_time_hash); // установка времени жизни куки для авторизации

// captcha
define("RECAPTCHA_HTML", $recaptcha_key_html);
define("RECAPTCHA_INSIDE", $recaptcha_key_inside);