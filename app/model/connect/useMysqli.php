<?php

namespace model\connect;

use model\function\translations;
use controller\error\error_manager;

class useMysqli
{
    // object language
    protected object $translations; // lang
    protected object $error_manager; // error
    // for db
    public $mysql = null;
    public $query = null;
    public $count_query; // count query
    // log query
    public $registry_sql_echo; // array with the querys
    // connect db


    protected function set_db()
    {
        $this->dependency_injection();
        if (!$this->mysql) {
            $this->mysql = new \mysqli(HOST_DB, USER_DB, PASS_DB, NAME_DB);
            $this->mysql->set_charset("utf8");
            // check connect
            if ($this->mysql->connect_error) {
                $this->error_manager->add_error(
                    $this->translations->get_message(
                        'mysql',
                        'error_connecting'
                    ) . $this->mysql->connect_error
                );
            }
        }
    }

    protected function dependency_injection()
    {
        // setting error object
        $this->error_manager = error_manager::get_instance();
        // set object for enter of language
        $this->translations = translations::getInstance();
    }

    // checking for the presence of data on a back request
    protected function sql_true($echo = true)
    {
        // checking the request
        $result = ($this->query->num_rows >= 1) ? true : false;
        if (!$result && $echo) {
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'mysql',
                    'nothing_was_found'
                )
            );
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

    // a small registry writes queries to the database
    protected function registry_sql($sql, $dir = false)
    {
        //$str = date("d.m.Y H:i:s") . ' | ' . $sql . ' | ' . IN_URL . ' | ' . IP . ". \r\n";
        $str = date("d.m.Y H:i:s") . ' | ' . $sql . ". \r\n";
        $this->registry_sql_echo[] = $str;
        // writing to file
        $new = fopen(PATH . DS . 'app' . DS . 'logs' . DS . $dir . DS . "log_sql_" . date("m-Y") . ".txt", "a");
        fwrite($new, $str);
        fclose($new);
    }
}
