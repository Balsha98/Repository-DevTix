<?php

class Sanitize
{
    /**
     * Cleaning a string.
     * @param string $value - string to be cleaned.
     * @return string - clean string.
     */
    public static function sanitizeString(string $value)
    {
        return htmlspecialchars(strip_tags(trim($value)));
    }
}
