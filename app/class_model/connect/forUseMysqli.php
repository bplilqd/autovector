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
        // trim and remove extra spaces for correction request
        $sql = preg_replace("/\s{2,}/", ' ', trim($sql_in));
        // connect to db
        $this->set_db();
        // request
        $this->query = $this->mysql->query($sql);
        // check result
        $result = $this->sql_true($echo);
        if (!$no_log) {
            // calculate database query
            $this->count_query_for_db(__FUNCTION__, $sql, $result);
            // writing query to the log
            $this->registry_sql($sql, 'log_sql');
        }
        return $result;
    }

    // DELETE sql
    public function sql_delete($sql)
    {
        // connect to db
        $this->set_db();
        // request
        $result = $this->query = $this->mysql->query($sql);
        // calculate database query
        $this->count_query_for_db(__FUNCTION__, $sql, $result);
        // writing query to the log
        $this->registry_sql($sql, 'log_sql');
        return $result;
    }

    // UPDATE sql
    public function sql_update($sql, $no_log = false)
    {
        // connect to db
        $this->set_db();
        // request
        $result = $this->query = $this->mysql->query($sql);
        if (!$no_log) {
            // calculate database query
            $this->count_query_for_db(__FUNCTION__, $sql, $result);
            // writing query to the log
            $this->registry_sql($sql, 'log_sql');
        }
        return $result;
    }

    // INSERT sql
    public function sql_insert($sql)
    {
        // connect to db
        $this->set_db();
        // request
        $result = $this->query = $this->mysql->query($sql);
        // calculate database query
        $this->count_query_for_db(__FUNCTION__, $sql, $result);
        // writing query to the log
        $this->registry_sql($sql, 'log_sql');
        return $result;
    }

    // collects the query string for INSERT INTO
    public function insert_set_and_add($name_table, $array)
    {
        $str = "INSERT INTO `$name_table` ";
        // preparing keys into values ​​in an array
        foreach ($array as $key => $value) {
            $arr_keys[] = $key;
        }
        // we break the old keys
        $str_keys = "`";
        $str_keys .= implode("`,`", $arr_keys);
        $str_keys .= "`";
        // break down the values
        $str_values = "'";
        $str_values .= implode("','", $array);
        $str_values .= "'";

        $str .= "(" . $str_keys;
        $str .= ") VALUES (";
        $str .= $str_values . ")";
        // to db
        $result = $this->sql_insert($str);
        return $result;
    }
}
