<?php

class Redirect
{
    public static function toRoute(string $route)
    {
        header("Location: {$route}");
    }
}
