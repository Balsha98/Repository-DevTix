<?php

class Redirect
{
    /**
     * Redirects to different view.
     * @param string $route - next route.
     * @return void - redirects the user.
     */
    public static function toRoute(string $route)
    {
        header("Location: {$route}");
    }
}
