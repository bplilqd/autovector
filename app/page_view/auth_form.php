<?php

namespace view;

class auth_form implements interface_auth_form
{
    protected $test;
    protected $array;
    protected $form;
    static $error_arr;

    public function form($array)
    {
        $this->array = $array;
        $this->set_form();
        return $this->form;
    }
    protected function set_form()
    {
        $disabled = '';
        $phone = '';
        $help_text = 'Введите номер телефона на котором есть WhathsApp';
        $active_input_pass = false;
        if ($this->array) {
            $phone = $this->array['auth_form']['phone'];
            if ($phone) {
                $help_text = 'Ввести <a href="index.php">другой номер</a>';
                $disabled = ' disabled';
                $active_input_pass = true;
            }
        }
        $str = '
    <form method="post" action="">
        <div class="mb-3">
            <label for="phone" class="form-label">Телефон</label>
            <input name="phone" value="' . $phone . '" type="phone" class="form-control" 
            id="phone" aria-describedby="phoneHelp" placeholder="' . $phone . '"' . $disabled . '>
            <div id="phoneHelp" class="form-text">'.$help_text.'</div>
        </div>';

        if ($active_input_pass) {
            $str .= '
        <div class="mb-3">
            <label for="pass" class="form-label">Пароль</label>
            <input name="pass" type="password" class="form-control" id="pass">
            <input type="hidden" name="set_phone" value="true">
            <input type="hidden" name="phone" value="' . $phone . '">
        </div>
        ';
        }
        $str .= '
        <button type="submit" name="auth_submit" value="auth_submit" class="btn btn-primary">Отправить</button>
    </form>';
        $this->form = $str;
    }
}
