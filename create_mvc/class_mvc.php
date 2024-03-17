<?php

class class_mvc
{

    protected $json;
    protected $array;

    function __construct($json)
    {
        $this->set_parm($json); // set json
        $this->parse_resource(); // decode json to array for next work
        $str = $this->create_dir($this->array);
        print_r($str);
    }

    protected function parse_resource()
    {
        $json = $this->json;
        $array = json_decode($json, true);
        $this->array = $array;
    }

    protected function set_parm($json)
    {
        $this->json = $json;
    }

protected function create_dir_new($array, $path = '')
{
    $str = '';

    foreach ($array as $key => $value) {
        // Создаем путь к текущей директории
        $currentPath = $path . '/' . $key;

        // Если значение - массив и не пустое
        if (is_array($value) && !empty($value)) {
            // Создаем директорию
            mkdir($currentPath, 0777, true);

            // Вызываем рекурсивно эту же функцию для обработки вложенных массивов
            $str .= $this->create_dir($value, $currentPath);
        } else {
            // Если значение не пустое
            if ($value) {
                // Создаем директорию с текущим путем и значением как ее именем
                mkdir($currentPath, 0777, true);
                $str .= "\n" . ' [ ' . $currentPath . ' (d) ] ';
            } else {
                // Создаем пустую директорию с текущим путем и ключом как ее именем
                mkdir($currentPath, 0777, true);
                $str .= "\n" . ' [ ' . $currentPath . ' (e) ] ';
            }
        }
    }

    return $str;
}
    
    // method create directorys
    protected function create_dir($array, $path = '')
    {
        $str = '';
        foreach ($array as $key => $value) {
            if (gettype($value) == 'array' && $value) {
                $str .= "\n".' ['.$path.'/'.$key.' (a)] ';
                // if arr to parse for foreach
                foreach ($value as $key2 => $value2) {
                    // don't array
                    if (gettype($value2) != 'array' && $value2) {
                        $str .= "\n".'  [ '.$path.'/'.$key.'/'.$value2.' (b)] ';
                    } else {
                        // repost this function
                        if ($value2) {
                            $str .= "\n".' [ '.$path.'/'.$key.'/'.$key2.' (c)] - "restart function" ';
                            $str .= $this->create_dir($value2, $path.'/'.$key.'/'.$key2);
                        }
                    }
                }
            } else {
                if ($value) {
                    $str .= "\n".' [ '.$path.'/'.$value.' (d)] ';
                } else {
                    $str .= "\n".' [ '.$path.'/'.$key.' (e)] ';
                }
            }
        }
    return $str;
    }
}
