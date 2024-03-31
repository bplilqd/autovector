<?php

namespace model\connect;

class useMysqli
{
    // for db
    public $mysql = null;
    public $query = null;
    static $count_query; // count query
    // handler of systeam messages
    static $error_arr; // array with errors
    // log query
    static $registry_sql_echo; // array with the querys
    // connect db

    protected function set_db()
    {
        if (!$this->mysql) {
            $this->mysql = new \mysqli(HOST_DB, USER_DB, PASS_DB, NAME_DB);
            $this->mysql->set_charset("utf8");
            // check connect
            if ($this->mysql->connect_error) {
                $this->error_arr[] = "Ошибка подключения к базе данных: " . $this->mysql->connect_error;
            }
        }
    }

    // проверка на присутствие данных по задпнному запросу
    protected function sql_true($echo = true)
    {
        // проверяем запрос
        $result = ($this->query->num_rows >= 1) ? true : false;
        if (!$result && $echo) {
            $this->error_arr[] = 'По вашему запросу ничего не найдено!';
        }
        return $result;
    }

    protected function count_query_for_db($what_fun, $sql, $query_result = false)
    {
        $this->count_query[] = [
            'sql_str' => $sql,
            'fun' => $what_fun,
            'time' => microtime(true),
            'result' => $query_result
        ];
    }

    // небольшой реестр пишет запросы в базу данных
    protected function registry_sql($sql, $dir = false)
    {
        //$str = date("d.m.Y H:i:s") . ' | ' . $sql . ' | ' . IN_URL . ' | ' . IP . ". \r\n";
        $str = date("d.m.Y H:i:s") . ' | ' . $sql . ". \r\n";
        $this->registry_sql_echo[] = $str;
        // запись в файл
        $new = fopen(PATH . DS . 'app' . DS . 'log' . DS . $dir . DS . "log_sql_" . date("m-Y") . ".txt", "a");
        fwrite($new, $str);
        fclose($new);
    }
}
