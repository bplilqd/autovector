<?php

class class_mvc
{

    protected $json;
    protected $array;
    protected $path;

    function __construct($json, $path)
    {
        $this->path = $path;
        $this->set_parm($json); // set json
        $this->parse_resource(); // decode json to array for next work
        $str = $this->create_dir($this->array, $this->path);
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
    protected function create_dir($array, $path = "")
    {
        $str = "";
        foreach ($array as $key => $value) {
            if (is_array($value) && $value) {
                $str .= "\n" . ' [' . $path . '/' . $key . ' (a)] ';
                mkdir($path . DS . $key, 0755);

                // if arr to parse for foreach
                foreach ($value as $key2 => $value2) {

                    // don't array
                    if (!is_array($value2) && $value2) {
                        $str .= "\n" . '  [ ' . $path . '/' . $key . '/' . $value2 . ' (b)] ';
                        mkdir($path . DS . $key . DS . $value2, 0755);
                    } else {

                        // repost this function
                        if ($value2) {
                            $str .= "\n" . ' [ ' . $path . '/' . $key . '/' . $key2 . ' (c)] - "restart function" ';
                            mkdir($path . DS . $key . DS . $key2, 0755);
                            $str .= $this->create_dir($value2, $path . '/' . $key . '/' . $key2);
                        }
                    }
                }
            } else {
                if ($value) {
                    $str .= "\n" . ' [ ' . $path . '/' . $value . ' (d)] ';
                    mkdir($path . DS . $value, 0755);
                } else {
                    $str .= "\n" . ' [ ' . $path . '/' . $key . ' (e)] ';
                    mkdir($path . DS . $key, 0755);
                }
            }
        }
        return $str;
    }
}
