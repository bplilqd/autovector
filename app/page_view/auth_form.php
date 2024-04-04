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
        $active_input_pass = false;
        if ($this->array['auth_form']['phone']) {
            $disabled = ' disabled';
            $active_input_pass = true;
        }
        $str = '
    <form>
        <div class="mb-3">
            <label for="phone" class="form-label">Телефон</label>
            <input name="phone" value="' . $this->array['auth_form']['phone'] . '" type="phone" class="form-control" 
            id="phone" aria-describedby="phoneHelp" placeholder="' . $this->array['auth_form']['phone'] . '"' . $disabled . '>
            <div id="phoneHelp" class="form-text">Введите номер телефона на котором есть WhathsApp</div>
        </div>';

        if ($active_input_pass) {
            $str .= '
        <div class="mb-3">
            <label for="pass" class="form-label">Пароль</label>
            <input name="pass" type="password" class="form-control" id="pass">
            <input type="hidden" name="phone" value="' . $this->array['auth_form']['phone'] . '">
        </div>
        ';
        }
        $str .= '
        <button type="submit" name="auth_submit" value="auth_submit" class="btn btn-primary">Отправить</button>
    </form>';
        $this->form = $str;
    }
}
