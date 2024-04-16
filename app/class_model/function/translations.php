<?php

namespace model\function;

interface interface_translations
{
    public function set_lang($lang);
}

class translations implements interface_translations
{

    public string $lang;
    public $auth;

    public function set_lang($lang)
    {
        $this->lang = $lang;
        $this->auth = include __DIR__.'/../../../lang/' . $lang . '/auth.php';
    }
}

//$translations = new translations;
//$translations->set_lang('ru');
//print_r($translations->auth['not_correct_format_number']);
