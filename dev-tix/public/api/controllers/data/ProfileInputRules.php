<?php

class ProfileInputRules
{
    public const RULES = [
        'username' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 25
            ],
        ],
        'first_name' => [
            'type' => 'str',
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 30
            ],
        ],
        'last_name' => [
            'type' => 'str',
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 30
            ],
        ],
        'email' => [
            'type' => 'email'
        ],
        'bio' => [
            'type' => 'str',
            'pattern' => 'special_cases',
            'length' => [
                'min' => 10,
                'max' => 250
            ],
        ],
        'age' => [
            'type' => 'int',
            'length' => [
                'min' => 1,
                'max' => 100
            ]
        ],
        'profession' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 50
            ],
        ],
        'country' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 50
            ],
        ],
        'city' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 3,
                'max' => 50
            ],
        ],
        'zip' => [
            'type' => 'int',
            'length' => [
                'min' => 1,
                'max' => 1000000
            ],
        ],
    ];
}
