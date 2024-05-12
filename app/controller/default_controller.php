<?php

namespace controller;

class default_controller extends main_controller
{

    function __construct()
    {
        // controller ->
        // standart methods -> set request, set hash from browser, set object of model and others...
        $this->set_standart();

        // model ->
        // set user auth
        $this->model->set_user($this->hash);
        

        // view ->
        // set view -> template
        $this->view = new ('view\\' . NAME_VIEW);
        // start work for to model -> option/settings
        $this->model->set_and_setting();
        // set of the settings user
        $this->settings_user();
        // for print errors
        $this->view->error_print();
        // set_menu
        if ($this->model->auth) {
            $this->view->set_menu();
        }
        // title
        $this->view->setting_properties('title', $this->translations->get_message('content_page', 'welcome'));
        // set_foot
        $this->view->set_foot($this->model->count_request());
        // include theme
        $this->view->include_theme();
    }

}
