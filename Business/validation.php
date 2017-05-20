<?php

class Validation
{


    /*Empty Validation*/
    public static function isEmpty($value)
    {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }


    //Validation for Name
    public static function checkName($string) {
            if (preg_match("/^[a-zA-Z ]*$/", $string)) {
                return true;
            } else {
                return false;
            }
        }

    //Validate Email
    public static function emailValid($string) {
        if(!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }
}