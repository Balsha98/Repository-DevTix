<?php

class Debug
{
    /**
     * Print data to debug.
     * @param mixed $data - any type of data.
     * @return void - prints the data.
     */
    public static function debug(mixed $data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }
}
