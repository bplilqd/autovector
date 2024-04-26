<?php

namespace view;

interface interface_view
{
    // print template
    public function include_theme();
    // for error print
    public function error_print();
    // function the input data of properties
    public function setting_properties($property, $change_or_set_parm = '', $start_parm = '', $end_parm = '');
    // function the output data
    public function getting_properties($property);
    // method for setting values ​​as an array for an html template
    public function properties_array($property, $array);
}
