<?php

namespace view\form;

use model\function\translations;

class form_settings_user extends form implements interface_form
{
    protected $language_data = ['ru', 'en'];
    protected $user_theme_data = ['theme', 'design'];

    public function form($date)
    {
        // set object for enter of language
        $this->translations = translations::getInstance();
        // data
        $this->date = $date;
        // set
        $this->option_setting_form();
        // sent
        return $this->form;
    }

    private function set_option_form_select($data, $name_select)
    {
        $result_str = '';
        foreach ($data as $value) {
            $selected = '';
            if ($value == $name_select) {
                $selected = ' selected';
            }
            $result_str .= '<option' . $selected . ' value="' . $value . '">' . $value . '</option>' . "\n";
            unset($selected);
        }
        return $result_str;
    }

    private function set_form($option_user_theme, $option_language, $submit, $checked_data_bs_theme, $dark_theme, $lang_default, $theme_default)
    {
        $form = '
        <form>
        <div class="row">

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" name="data_bs_theme" type="checkbox" role="switch" id="data_bs_theme"' . $checked_data_bs_theme . '>
              <label class="form-check-label" for="data_bs_theme">' . $dark_theme . '</label>
            </div>
          </div>

          <div class="mb-3">
            <label for="user_theme_default" class="form-label">' . $theme_default . '</label>
            <select class="form-select" name="user_theme" id="user_theme_default" aria-label="' . $theme_default . '">
              ' . $option_user_theme . '
            </select>
          </div>
          
          <div class="mb-3">
            <label for="language_default" class="form-label">' . $lang_default . '</label>
            <select class="form-select" name="language" id="language_default" aria-label="' . $lang_default . '">
              ' . $option_language . '
            </select>
          </div>

          <div class="mb-3">
            <button type="submit" name="submit_edit" class="btn btn-primary">' . $submit . '</button>
          </div>

        </div>
      </form>';
        $this->form = $form;
    }

    private function option_setting_form()
    {
        $date = $this->date;

        $checked_data_bs_theme = '';

        $edit_form_language = '';
        $edit_form_user_theme = '';
        $edit_form_data_bs_theme = '';

        if (isset($date['edit_form'])) {
            $edit_form_language = $date['edit_form']['language'];
            $edit_form_user_theme = $date['edit_form']['user_theme'];
            $edit_form_data_bs_theme = $date['edit_form']['data_bs_theme'];
        }

        $data_user_language = '';
        $data_user_user_theme = '';
        $data_user_data_bs_theme = '';

        if ($date['data_user']) {
            /*   
            example data from db:
            [language] => ru
            [user_theme] => theme
            [data_bs_theme] => dark
            */
            $data_user_language = $date['data_user']['language'];
            $data_user_user_theme = $date['data_user']['user_theme'];
            $data_user_data_bs_theme = $date['data_user']['data_bs_theme'];
        }

        $language = $edit_form_language ? $edit_form_language : $data_user_language;
        $user_theme  = $edit_form_user_theme ? $edit_form_user_theme : $data_user_user_theme;
        $data_bs_theme =  $edit_form_data_bs_theme ? $edit_form_data_bs_theme : $data_user_data_bs_theme;

        if ($data_bs_theme == 'dark') {
            $checked_data_bs_theme = ' checked';
        }

        $option_user_theme = $this->set_option_form_select($this->user_theme_data, $user_theme);;
        $option_language = $this->set_option_form_select($this->language_data, $language);

        $dark_theme = $this->translations->get_message('panel_user', 'dark_theme');
        $lang_default = $this->translations->get_message('panel_user', 'lang_default');
        $theme_default = $this->translations->get_message('panel_user', 'theme_default');
        $submit = $this->translations->get_message('panel_user', 'save');

        $this->set_form($option_user_theme, $option_language, $submit, $checked_data_bs_theme, $dark_theme, $lang_default, $theme_default);
    }
}
