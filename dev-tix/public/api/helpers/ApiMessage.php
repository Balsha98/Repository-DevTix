<?php

class ApiMessage
{
    public static function invalidRoute()
    {
        return ['error' => 'Invalid API route.'];
    }

    public static function invalidId()
    {
        return ['error' => "Record ID isn't specified."];
    }

    public static function invalidData()
    {
        return ['error' => 'Input data cannot be empty.'];
    }
}
