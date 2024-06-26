<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;
use view\form\edit_form_user;

class user_model extends model implements interface_user
{
    protected object $mysql;
    protected object $edit_form_user;
    // output data -> view
    public $data_user;

    public function __construct()
    {
        // set objects other
        $this->set_objects();
    }

    public function set_and_setting()
    {
        // if authorized. if allowed to continue
        if ($this->auth) {
            // data user for sent to wiew
            $this->set_data_user_for_view();
        }
    }

    public function edit_form($data)
    {
        $data_user = $this->data_user;

        $id = $this->user_config->id;
        if ($data['edit_form']) {
            $submit_edit = $data['edit_form']['submit_edit'];
            $name = $data['edit_form']['name'];
            $last_name = $data['edit_form']['last_name'];
        }

        // update in db
        if ($submit_edit) {
            $this->update_data_of_user_in_db($name, $last_name, $id);
        }

        $data['data_user'] = [
            'name' => $data_user['name'] ? $data_user['name'] : '',
            'last_name' => $data_user['last_name'] ? $data_user['last_name'] : '',
        ];

        return $this->edit_form_user->form($data);
    }

    protected function update_data_of_user_in_db($name, $last_name, $id)
    {
        $sql = "UPDATE `user` SET `name` = '$name', 
            `last_name` = '$last_name' 
            WHERE `id` = $id;";
        $this->mysql->sql_update($sql);
        header("Location: " . SITE_URL . "panel" . DS . "user");
    }

    protected function set_data_user_for_view()
    {
        $user_config = $this->user_config;

        $user_data = [
            'name' => $user_config->name,
            'last_name' => $user_config->last_name,
            'phone' => '+' . $user_config->phone,
            'email' => $user_config->email,
            'user_theme' => $user_config->user_theme,
            'data_bs_theme' => $user_config->data_bs_theme,
            'date' => date("d.m.Y", $user_config->sec)
        ];

        $this->data_user = $user_data;
    }

    protected function set_objects()
    {
        // set edit form user
        $this->edit_form_user = new edit_form_user;
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set user
        $this->user_config = new user_config;
    }
}
