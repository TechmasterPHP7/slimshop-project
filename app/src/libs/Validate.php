<?php

namespace App\Libs;


class Validate
{

    static function loginUser($input)
    {
        $input = trim($input);
        $input = stripcslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    /**
     * @param $input
     * @return bool
     */
    static function isValidUsername($input)
    {
      return preg_match('/^[a-zA-Z0-9]{6,12}$/',$input);
    }
    /**
     * @param $input
     * @return bool
     */
    static function isValidEmail($input)
    {
        return preg_match('/^([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}$/', $input);
    }
    /**
     * @param $input
     * @return bool
     */
    static function isValidPass($input)
    {
        return preg_match('/^[a-zA-Z0-9]{6,16}$/',$input);
    }
}
