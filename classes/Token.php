<?php
class Token
{
    //Generates security CSRF token
    public static function generate(){
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    //Checks if generated token matches {$token} token
    public function check($token)
    {
        $tokenName = Config::get('session/token_name');
        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}

