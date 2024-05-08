<?php

namespace view\messages;

class message implements interfaceMessage
{
    private static $instance;
    private $messages = [];

    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function messages($message, $style = '')
    {
        if ($style) {
            $this->messages[$style][] = $message;
        } else {
            $this->messages['seccondary'][] = $message;
        }
    }

    public function get_messages()
    {
        return $this->messages;
    }

    public function has_messages()
    {
        return !empty($this->messages);
    }
}
