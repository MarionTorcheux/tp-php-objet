<?php

namespace LidemFramework;

class SessionManager
{
    //pour pouvoir alimenter notre session
    public static function set(string $key, mixed $value):void
    {
        $_SESSION[$key] = $value;
    }

    //pour récupérer la session
    public static function get(string $key): mixed
    {
        if(!isset($_SESSION[$key])) return null;
        return $_SESSION[$key];
    }
    //pour vider la session
    public static function remove(string $key):void
    {
        if(!self::get($key)) return;
        unset($_SESSION[$key]);
    }
}