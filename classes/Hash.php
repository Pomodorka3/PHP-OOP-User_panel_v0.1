<?php
class Hash
{
    //Generates random string
    private function salt($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //Generates hash
    public static function make($string, $salt = '')
    {
        return hash('sha256', $string.$salt);
    }

    //Generates unique hash
    public static function unique()
    {
        return self::make(uniqid());
    }
}

