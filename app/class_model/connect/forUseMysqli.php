<?php

namespace model\connect;

class forUseMysqli extends useMysqli implements interfaceForUseMysqli
{

    // error array
    public function error_array()
    {
        return $this->error_arr;
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
    // соберает строку запроса для INSERT INTO
    public function insert_set_and_add($name_table, $array)
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
}
