<?php

class Session
{
    public static function start()
    {
        if (PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function isSet($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function end()
    {
        if (PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
