<?php

namespace view;

use model\function\translations;

class auth_form implements interface_auth_form
{
    protected $array = [];
    protected $form = '';
    protected object $translations; // lang

    public function form($array)
    {
        // set object for enter of language
        $this->translations = translations::getInstance();
        // data
        $this->array = $array;
        // set
        $this->set_form();
        // sent
        return $this->form;
    }
    protected function set_form()
    {
        $disabled = '';
        $phone = '';
        $help_text = $this->translations->get_message('auth_form', 'help_text');
        $active_input_pass = false;
        if ($this->array) {
            $phone = $this->array['auth_form']['phone'];
            if ($phone) {
                $help_text = $this->translations->get_message('auth_form', 'help_text2') .
                    ' <a href="index.php">' . $this->translations->get_message('auth_form', 'help_text3') . '</a>';
                $disabled = ' disabled';
                $active_input_pass = true;
            }
        }
        $str = '
    <form method="post" action="">
        <div class="mb-3">
            <label for="phone" class="form-label">' . $this->translations->get_message('auth_form', 'phone') . '</label>
            <input name="phone" value="' . $phone . '" type="phone" class="form-control" 
            id="phone" aria-describedby="phoneHelp" placeholder=""' . $disabled . ' required>
            <div id="phoneHelp" class="form-text">' . $help_text . '</div>
        </div>';
        if ($active_input_pass) {
            $str .= '
        <div class="mb-3">
            <label for="pass" class="form-label">' . $this->translations->get_message('auth_form', 'pass') . '</label>
            <input name="pass" type="password" class="form-control" id="pass" required>
            <input type="hidden" name="set_phone" value="true">
            <input type="hidden" name="phone" value="' . $phone . '">
        </div>
        ';
        }
        if (RECAPTCHA_ON) {
            $str .= '
        <div class="mb-3 g-recaptcha" data-theme="' . $this->invert_mode_theme(MODE_THEME) . '" data-sitekey="' . RECAPTCHA_HTML . '"></div>
        ';
        }
        $str .= '
        <button type="submit" name="auth_submit" value="auth_submit" class="btn btn-primary">' . $this->translations->get_message('auth_form', 'auth_submit') . '</button>
    </form>';
        $this->form = $str;
    }

    protected function invert_mode_theme($mode_theme)
    {
        $result = '';
        if ($mode_theme == 'light') {
            $result = 'dark';
        }
        if ($mode_theme == 'dark') {
            $result = 'light';
        }
        return $result;
    }
}
