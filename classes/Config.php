<?php

class Config
{
    //Gets parameters from defined config in init.php
    public static function get($path = null){
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $item) {
                if (isset($config[$item])) {
                    $config = $config[$item];
                }
            }

            return $config;
        }
        return false;
    }
}
