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
