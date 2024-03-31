<?php

namespace model\connect;

interface interfaceForUseMysqli
{
    // SELECT sql
    public function sql_select($sql_in, $echo = true, $no_log = false);
    // DELETE sql
    public function sql_delete($sql);
    // INSERT sql
    public function sql_insert($sql);
    // UPDATE sql
    public function sql_update($sql, $no_log = false);

}