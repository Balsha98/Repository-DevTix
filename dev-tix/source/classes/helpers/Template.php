<?php

class Template
{
    public static function buildTitle($page)
    {
        if (str_contains($page, '-')) {
            $page = array_map(function ($part) {
                if ($part !== 'admin') {
                    return ucfirst($part);
                }
            }, explode('-', $page));
        } else {
            $page = ucfirst($page);
        }

        return is_array($page) ? implode(' ', $page) : trim($page);
    }
}
