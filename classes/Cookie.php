<?php

class Cookie
{
    //Check whether cookie exists
    public static function exists($name)
    {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    //Gets value of a cookie
    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    //Creates cookie
    public static function put($name, $value, $expiry){
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    //Deletes cookie
    public static function delete($name)
    {
        self::put($name, '', time() - 1);
    }
}

