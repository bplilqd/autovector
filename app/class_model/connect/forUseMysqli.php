<?php

namespace model\connect;

class forUseMysqli implements interfaceForUseMysqli
{
    // for db
    public $mysql = null;
    public $query = null;
    static $count_query; // count query
    // handler of systeam messages
    static $error_arr; // array with errors
    static $success_arr; // array
    static $warning_arr; // array
    static $info_arr; // array info
    // log query
    static $registry_sql_echo; // array with the querys
    // connect db

    protected function set_db()
    {
        if (!$this->mysql) {
            $this->mysql = new \mysqli(HOST_DB, USER_DB, PASS_DB, NAME_DB);
            $this->mysql->set_charset("utf8");
            // Проверка соединения
            if ($this->mysql->connect_error) {
                $this->error_arr[] = "Ошибка подключения к базе данных: " . $this->mysql->connect_error;
            }
        }
    }

    // SELECT sql
    public function sql_select($sql_in, $echo = true, $no_log = false)
    {
        // trim и удаляем лишние пробелы в строке для чистого и корректного запроса
        $sql = preg_replace("/\s{2,}/", ' ', trim($sql_in));
        // соединение с базой
        $this->set_db();
        // запрос
        $this->query = $this->mysql->query($sql); // запрос
        // проверка результата
        $result = $this->sql_true($echo);
        if (!$no_log) {
            // подсчет запросов к базе
            $this->count_query_for_db(__FUNCTION__, $sql, $result);
            // пишем запрос в лог
            $this->registry_sql($sql, 'log_sql');
        }
        return $result;
    }

    // DELETE sql
    public function sql_delete($sql)
    {
        $this->set_db();
        $result = $this->query = $this->mysql->query($sql); // запрос
        // подсчет запросов к базе
        $this->count_query_for_db(__FUNCTION__, $sql, $result);
        $this->registry_sql($sql, 'log_sql');
        return $result;
    }

    // UPDATE sql
    public function sql_update($sql, $no_log = false)
    {
        $this->set_db();
        $result = $this->query = $this->mysql->query($sql); // запрос
        if (!$no_log) {
            // подсчет запросов к базе
            $this->count_query_for_db(__FUNCTION__, $sql, $result);
            $this->registry_sql($sql, 'log_sql');
        }
        return $result;
    }

    // INSERT sql
    public function sql_insert($sql)
    {
        $this->set_db();
        $result = $this->query = $this->mysql->query($sql); // запрос
        // подсчет запросов к базе
        $this->count_query_for_db(__FUNCTION__, $sql, $result);
        // пишем лог обращений
        $this->registry_sql($sql, 'log_sql');
        return $result;
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

    // соберает строку запроса для INSERT INTO
    protected function insert_set_and_add($name_table, $array)
    {
        $str = "INSERT INTO `$name_table` ";
        // подготовка ключи во значения в массив
        foreach ($array as $key => $value) {
            $arr_keys[] = $key;
        }
        // разбиваем бывшие ключи
        $str_keys = "`";
        $str_keys .= implode("`,`", $arr_keys);
        $str_keys .= "`";
        // разбиваем значения
        $str_values = "'";
        $str_values .= implode("','", $array);
        $str_values .= "'";

        $str .= "(" . $str_keys;
        $str .= ") VALUES (";
        $str .= $str_values . ")";
        $result = $this->sql_insert($str);
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
    private function registry_sql($sql, $dir = false)
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
