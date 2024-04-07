<?php

class p_slice_class {

    public $name_file_template = 'theme.html';
    public $file_template_html; // file after download
    public $arr_subject; // сигменты по которым нужно резать шаблон
    static $list_rec_ok; // отчет

    public function __construct() {
        // устанавливаем масив предметов нарезки
        $this->set_arr_for_cuts();
        // загружаем шаблон
        $this->set_open_file();
        // нарезка
        $this->slice_fun();
    }

    protected function set_arr_for_cuts() {
        $arr = [
            'header',
            'top',
            'menu',
            'system_mesage',
            'announce',
            'title',
            'sidebar',
            'content',
            'foot'
        ];
        $this->arr_subject = $arr;
    }

    // достаем шаблон в свойства
    protected function set_open_file() {
        $result = file_get_contents($this->name_file_template);
        $this->file_template_html = $result;
    }

    // режим шаблон на файлы
    protected function slice_fun() {
        $subject = $this->del_code($this->file_template_html);
        foreach ($this->arr_subject as $value) {
            $pattern = "/<!--$value-->(.*)<!--\/$value-->/is";
            $result = preg_match($pattern, $subject, $arr_result);
            $this->list_rec($result, $value);
            $this->rec_file($value, $arr_result[1]);
        }
    }

    // вырезать лишнее исключение по тегу
    protected function del_code($subject) {
        $pattern = '/<!--del--[^>]*?>.*?<!--\/del-->/is';
        $result = preg_replace($pattern, '', $subject);
        return $result;
    }

    // массив, небольшой отчет
    protected function list_rec($str, $val) {
        if ($str) {
            $this->list_rec_ok[] = $val;
        }
    }

    // записываем порезанный сигмент в файл
    protected function rec_file($name_file, $str) {
        $new = fopen("$name_file.html", "w+");
        fwrite($new, $str);
        fclose($new);
    }

}

$slice = new p_slice_class();

print_r($slice->list_rec_ok);
