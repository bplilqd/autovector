<?php

namespace view\form;

class form
{
    protected $date = [];
    protected $form = '';
    protected object $translations; // lang

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
