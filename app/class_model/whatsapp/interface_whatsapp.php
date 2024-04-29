<?php

namespace model\whatsApp;

interface interface_whatsapp
{
    // API Check WhatsApp availability by phone number
    // Request GET: https://wamm.chat/api2/check_phone/token/?phone=number
    public function check_phone($phone);

    // Adding and updating contacts
    // Request GET: https://wamm.chat/api2/contact_to/token/?phone=number&name=name&info=note&email=email&web=url
    public function contact_to($phone, $name, $info = false, $email = false, $web = false);

    // Sent mesages
    // Request GET: https://wamm.chat/api2/msg_to/token/?phone=number&text=text of mesage
    public function msg_to($phone, $message);
}
