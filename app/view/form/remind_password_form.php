<?php

namespace view\form;

use model\function\translations;

// example url of return http://localhost/autovector/panel/auth/?phone=79214604140&auth_submit=auth_submit
class remind_password_form extends form implements interface_form
{

    public function form($date)
    {
        // set object for enter of language
        $this->translations = translations::getInstance();
        // data
        $this->date = $date;
        // set
        $this->set_form();
        // sent
        return $this->form;
    }

    protected function set_form()
    {
        $text_phone = $this->translations->get_message('auth_form', 'phone');
        $help_text = $this->translations->get_message('auth_form', 'remind_pass_submit');

        $str = '
    <form method="post" action="">
        <div class="mb-3">
            <label for="phone" class="form-label">' . $text_phone . '</label>
            <input name="phone" value="' . $this->date['remind_password_form']['phone'] . '" type="phone" class="form-control" id="phone" aria-describedby="phoneHelp" placeholder="" required>
            <div id="phoneHelp" class="form-text">' . $help_text . '</div>
        </div>';
        // setting recaptcha
        $str .= $this->recaptcha();
        $str .= '
        <button type="submit" name="auth_remind_pass" value="auth_remind_pass" class="btn btn-primary">' . $this->translations->get_message('auth_form', 'auth_submit') . '</button>
    </form>';
        $this->form = $str;
    }

    protected function recaptcha()
    {
        if (RECAPTCHA_ON) {
            return '
        <div class="mb-3 g-recaptcha" data-theme="' . $this->invert_mode_theme(MODE_THEME) . '" data-sitekey="' . RECAPTCHA_HTML . '"></div>
        ';
        }
    }
}
