<?php

class Validate
{
    private const PATTERNS = [
        'only_letters' => '#^[^a-zA-Z]$#',
        'no_symbols' => '#^[^a-zA-Z0-9]$#'
    ];

    public static function validateInputs(array $data, array $rules)
    {
        foreach ($data as $key => $value) {
            if (isset($rules[$key])) {
            }
        }
    }
}
