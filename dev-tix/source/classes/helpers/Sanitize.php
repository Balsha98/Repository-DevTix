<?php

class Sanitize
{
    public static function sanitizeString(string $value)
    {
        return htmlspecialchars(strip_tags(trim($value)));
    }
}
