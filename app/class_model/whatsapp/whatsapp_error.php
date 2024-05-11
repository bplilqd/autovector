<?php

namespace model\whatsapp;

use model\function\translations;

class whatsapp_error extends whatsapp_main
{

    protected object $translations; // lang

    private function language()
    {
        // set object for enter of language
        $this->translations = translations::getInstance();
    }

    protected function err_for_contact_to($err)
    {
        $this->language();
        $arr_err = [
            'token fail' => $this->translations->get_message(
                'whatsapp',
                'token_fail'
            ),
            'acc not authorized' => $this->translations->get_message(
                'whatsapp',
                'acc_not_authorized'
            ),
            'phone fail' => $this->translations->get_message(
                'whatsapp',
                'phone_fail'
            ),
            'no WhatsApp on the number' => $this->translations->get_message(
                'whatsapp',
                'no_whatsApp_on_the_number'
            ),
            'phone not checked for WhatsApp, please retry' => $this->translations->get_message(
                'whatsapp',
                'phone_not_checked_for_WhatsApp_please'
            ),
            'name fail' => $this->translations->get_message(
                'whatsapp',
                'name_fail'
            ),
            'name fail, more 250' => $this->translations->get_message(
                'whatsapp',
                'name_fail_more_250'
            ),
            'web fail, more 150' => $this->translations->get_message(
                'whatsapp',
                'web_fail_more_150'
            ),
            'email fail, more 150' => $this->translations->get_message(
                'whatsapp',
                'email_fail_more_150'
            ),
        ];
        $function = __FUNCTION__;
        return $this->exists_err($err, $arr_err, $function);
    }

    protected function err_for_check_phone($err)
    {
        $this->language();
        $arr_err = [
            'token fail' => $this->translations->get_message(
                'whatsapp',
                'token_fail'
            ),
            'acc not authorized' => $this->translations->get_message(
                'whatsapp',
                'acc_not_authorized'
            ),
            'fail execution' => $this->translations->get_message(
                'whatsapp',
                'fail_execution'
            )
        ];
        $function = __FUNCTION__;
        return $this->exists_err($err, $arr_err, $function);
    }

    protected function err_for_msg_to($err)
    {
        $this->language();
        $arr_err = [
            'token fail' => $this->translations->get_message(
                'whatsapp',
                'token_fail'
            ),
            'acc not authorized' => $this->translations->get_message(
                'whatsapp',
                'acc_not_authorized'
            ),
            'phone fail' => $this->translations->get_message(
                'whatsapp',
                'phone_fail'
            ),
            'no WhatsApp on the number' => $this->translations->get_message(
                'whatsapp',
                'no_whatsApp_on_the_number'
            ),
            'phone not checked for WhatsApp, please retry' => $this->translations->get_message(
                'whatsapp',
                'phone_not_checked_for_WhatsApp_please'
            ),
            'text fail' => $this->translations->get_message(
                'whatsapp',
                'text_fail'
            ),
            'text fail, more 1500' => $this->translations->get_message(
                'whatsapp',
                'text_fail_more_1500'
            )
        ];
        $function = __FUNCTION__;
        return $this->exists_err($err, $arr_err, $function);
    }

    private function exists_err($err, $arr_err, $function)
    {
        if (array_key_exists($err, $arr_err)) {
            $str = $arr_err[$err];
        } else {
            $str = $this->translations->get_message(
                'whatsapp',
                'unknown_error_in'
            ) . ' ' . $function;
        }
        return $str;
    }
}
