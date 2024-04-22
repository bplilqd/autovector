<?php

namespace view\form;

use model\function\translations;

class auth_form extends form implements interface_form
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

    protected function option_form()
    {
        $disabled = '';
        $phone = '';
        $help_text = $this->translations->get_message(
            'auth_form',
            'help_text'
        );
        $active_input_pass = false;
        if ($this->date) {
            $phone = $this->date['auth_form']['phone'];
            if ($phone) {
                $help_text = $this->translations->get_message(
                    'auth_form',
                    'help_text2'
                ) .
                    ' <a href="index.php">' . $this->translations->get_message('auth_form', 'help_text3') . '</a>';
                $disabled = ' disabled';
                $active_input_pass = true;
            }
        }
        return [$disabled, $phone, $help_text, (bool) $active_input_pass];
    }

    protected function set_form()
    {
        $date = $this->option_form();
        $disabled = $date[0];
        $phone = $date[1];
        $help_text = $date[2];
        $active_input_pass = $date[3];
        $text_phone = $this->translations->get_message('auth_form', 'phone');
        $text_pass = $this->translations->get_message('auth_form', 'pass');
        $str = '
    <form method="post" action="">
        <div class="mb-3">
            <label for="phone" class="form-label">' . $text_phone . '</label>
            <input name="phone" value="' . $phone . '" type="phone" class="form-control" 
            id="phone" aria-describedby="phoneHelp" placeholder=""' . $disabled . ' required>
            <div id="phoneHelp" class="form-text">' . $help_text . '</div>
        </div>';
        if ($active_input_pass) {
            $str .= '
        <div class="mb-3">
            <label for="pass" class="form-label">' . $text_pass . '</label>
            <input name="pass" type="password" class="form-control" id="pass" required>
            <input type="hidden" name="set_phone" value="true">
            <input type="hidden" name="phone" value="' . $phone . '">
        </div>
        ';
        }
        // setting recaptcha
        $this->recaptcha();
        $str .= '
        <button type="submit" name="auth_submit" value="auth_submit" class="btn btn-primary">' . $this->translations->get_message('auth_form', 'auth_submit') . '</button>
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
