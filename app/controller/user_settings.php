<?php

namespace controller;

use view\not_authorized_view;
use model\function\scan_dir;

class user_settings extends main_controller
{

    private object $scan_dir;
    private object $not_authorized;

    function __construct()
    {
        // controller ->
        $this->set_in_controller();
        // model ->
        $this->set_in_model();
        // view ->
        $this->set_in_view();
    }

    // controller ->
    private function set_in_controller()
    {
        // standart methods -> set request, set hash from browser, set object of model and others...
        $this->set_standart();
    }

    // model ->
    private function set_in_model()
    {
        // set user auth
        $this->model->set_user($this->hash);
        // start work for to model -> option/settings
        $this->model->set_and_setting();
    }

    // view ->
    private function set_in_view()
    {
        // set view -> template
        $this->view = new ('view\\' . NAME_VIEW);
        // set of the settings user
        $this->settings_user();
        // if authorized -> view...
        if ($this->model->auth) {
            // sent data for set in wiew
            $this->view->input_data_user($this->model->data_user);
            // set title
            $title_user_page = $this->translations->get_message(
                'panel_user',
                'title_user_settings'
            );
            $this->view->setting_properties('title', $title_user_page);
            // set content
            $this->edit_settings();
            // set menu
            $this->view->set_menu();
            // more if authorized
            $this->more_setting_default('view');
        } else {
            // if not authorized -> not_authorized
            // error and redirect
            $this->error_manager->add_error(
                $this->translations->get_message(
                    'auth',
                    'not_authorized'
                )
            );
            header("refresh:5; url=" . SITE_URL . 'panel' . DS . 'auth');
            // set other object of view
            $this->not_authorized = new not_authorized_view;
            // set this method if there is no authorization
            $this->more_setting_default('not_authorized');
        }
    }

    private function edit_settings()
    {
        // set object scan_dir
        $this->scan_dir = new scan_dir;
        // scan dir lang and template
        $data = $this->scan_dir->scan_dir_lang_and_template();
        if ($this->request) {
            $request = $this->request;
            if (isset($request['submit_edit'])) {
                
                $data_bs_theme = strip_tags($request['data_bs_theme']);
                $edit_form_data_bs_theme = $this->check_dark_mode($data_bs_theme);

                $data['edit_form'] = [
                    'submit_edit' => true,
                    'language' => strip_tags($request['language']),
                    'data_bs_theme' => $edit_form_data_bs_theme,
                    'user_theme' => strip_tags($request['user_theme'])
                ];
            }
        }
        $content = $this->model->edit_form($data);
        $this->view->setting_properties('content', $content);
    }

    private function check_dark_mode($data_bs_theme)
    {
        if ($data_bs_theme == 'on') {
            return 'dark';
        } else {
            return 'light';
        }
    }

    private function more_setting_default($view_namme)
    {
        // set_foot
        $this->$view_namme->set_foot($this->model->count_request());
        // for print errors
        $this->$view_namme->error_print();
        // include theme
        $this->$view_namme->include_theme();
    }

}
