<?php

class Debug
{
    public static function debug(mixed $data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }
}
