<?php

require_once __DIR__ . '/Database.php';

class Session
{
    /**
     * Start a session.
     */
    public static function start()
    {
        if (PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get session value.
     * @param string $key - key of value.
     * @return mixed - desired value.
     */
    public static function get(string $key)
    {
        return $_SESSION[$key];
    }

    /**
     * Get database instance.
     * @return Database - database instance.
     */
    public static function getDbInstance()
    {
        return Database::getInstance();
    }

    /**
     * Check if session variable is set.
     * @param string $key - variable key.
     * @return bool - true/false.
     */
    public static function isSet(string $key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Create a new session variable.
     * @param string $key - variable key.
     * @param mixed $value - varable value.
     */
    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * End a session if it exists.
     */
    public static function stop()
    {
        if (PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
