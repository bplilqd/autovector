<?php

namespace view\messages;

interface interfaceMessage
{
    // set object if needed
    public static function get_instance();
    // set new message
    public function messages($message, $style = '');
    // get_messages
    public function get_messages();
    // check messages
    public function has_messages();
}