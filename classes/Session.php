<?php
class Session
{
    //Checks whether session with a given name exists
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    //Puts a value to a session
    public static function put($name, $value)
    {
        return @$_SESSION[$name] = $value;
    }

    //Gets a value from a session
    public function get($name)
    {
        return $_SESSION[$name];
    }

    //Deletes session
    public function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    //Flashes a message to a user, then removes it
    public function flash($name, $string = '')
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }
}

