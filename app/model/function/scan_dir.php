<?php

namespace model\function;

class scan_dir implements interface_scan_dir
{
    public function scan_dir_lang_and_template()
    {
        // language
        $path_lang = realpath(PATH . DS . 'app' . DS . 'view' . DS . 'lang');
        $array['language_data'] = $this->how_many_directories($path_lang);

        // theme
        $path_template = realpath(PATH . DS . 'app' . DS . 'view' . DS . 'template');
        $array['user_theme_data'] = $this->how_many_directories($path_template);
        return $array;
    }
    
    // check how many directories are inside
    private function how_many_directories($path)
    {
        $directories = scandir($path);
        $result = array_diff($directories, ['.', '..']);
        return $result;
    }
}
