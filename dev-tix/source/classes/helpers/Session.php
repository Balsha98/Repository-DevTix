<?php

class Session
{
    public static function start()
    {
        if (PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getVar($key)
    {
        return $_SESSION[$key];
    }

    public static function setVar($key, $value)
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
