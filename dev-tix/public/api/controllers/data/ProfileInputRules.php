<?php

class ProfileInputRules
{
    // Constants.
    public const RULES = [
        'username' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 25
            ]
        ],
        'password' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 25
            ]
        ],
        'first_name' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 30
            ]
        ],
        'last_name' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 30
            ]
        ],
        'email' => [
            'type' => 'email',
            'required' => true
        ],
        'bio' => [
            'type' => 'str',
            'required' => false,
            'pattern' => 'special_cases',
            'length' => [
                'min' => 10,
                'max' => 250
            ]
        ],
        'age' => [
            'type' => 'int',
            'required' => false,
            'length' => [
                'min' => 1,
                'max' => 100
            ]
        ],
        'profession' => [
            'type' => 'str',
            'required' => false,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 50
            ]
        ],
        'country' => [
            'type' => 'str',
            'required' => false,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 50
            ]
        ],
        'city' => [
            'type' => 'str',
            'required' => false,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 3,
                'max' => 50
            ]
        ],
        'zip' => [
            'type' => 'int',
            'required' => false,
            'length' => [
                'min' => 1,
                'max' => 1000000
            ]
        ],
    ];
}
