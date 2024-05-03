<?php

namespace model;

use model\settings\user_config;
use model\connect\forUseMysqli;
use view\form\form_settings_user;

class user_settings extends model implements interface_settings
{
    protected object $mysql;
    protected object $form_settings;
    // output data -> view
    public $data_user = [];

    public function __construct()
    {
        // set objects other
        $this->set_objects();
    }

    public function set_and_setting()
    {
        // if authorized. if allowed to continue
        if ($this->auth) {
            // data user for sent to wiew or form
            $this->set_data_user_for_view();
        }
    }

    public function edit_form($data)
    {
        $data_user = $this->data_user;
        $submit_edit = '';
        $id = $this->user_config->id;
        if (isset($data['edit_form'])) {
            $submit_edit = $data['edit_form']['submit_edit'];
            $language = $data['edit_form']['language'];
            $user_theme = $data['edit_form']['user_theme'];
            $data_bs_theme = $data['edit_form']['data_bs_theme'];
        }

        // update in db
        if ($submit_edit) {
            $this->update_data_of_user_in_db($id, $language, $user_theme, $data_bs_theme);
        }

        $data['data_user'] = [
            'language' => $data_user['language'],
            'user_theme' => $data_user['user_theme'],
            'data_bs_theme' => $data_user['data_bs_theme']
        ];

        return $this->form_settings->form($data);
    }

    public function scan_dir_lang_and_template()
    {
        $path_lang = realpath(__DIR__ . '/../page_view' . DS . 'lang');
        $array['language_data'] = $this->how_many_directories($path_lang);
        $path_template = realpath(__DIR__ . '/../page_view' . DS . 'template');
        $array['user_theme_data'] = $this->how_many_directories($path_template);
        return $array;
    }

    // check how many directories are inside
    private function how_many_directories($path)
    {
        $directories = scandir($path);
        $result = array_diff($directories, ['.', '..']);
        return $result;
    }

    private function update_data_of_user_in_db($id, $language, $user_theme, $data_bs_theme)
    {
        $sql = "UPDATE `user` SET `language` = '$language', 
        `user_theme` = '$user_theme', 
        `data_bs_theme` = '$data_bs_theme' 
        WHERE `id` = $id;";
        $this->mysql->sql_update($sql);
        header("Location: " . SITE_URL . "panel" . DS . "user" . DS . "settings");
    }

    private function set_data_user_for_view()
    {
        $user_config = $this->user_config;
        /*   example data from db 
        [language] => ru
        [user_theme] => theme
        [data_bs_theme] => dark
        */
        $user_data = [
            'language' => $user_config->language,
            'user_theme' => $user_config->user_theme,
            'data_bs_theme' => $user_config->data_bs_theme
        ];

        $this->data_user = $user_data;
    }

    private function set_objects()
    {
        // set form
        $this->form_settings = new form_settings_user;
        // set object for connect mysql
        $this->mysql = new forUseMysqli;
        // set user
        $this->user_config = new user_config;
    }
}
