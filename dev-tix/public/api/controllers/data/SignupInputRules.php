<?php

class SignupInputRules
{
    public const RULES = [
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
        'age' => [
            'type' => 'int',
            'length' => [
                'min' => 1,
                'max' => 100
            ]
        ],
        'username' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 25
            ],
        ],
        'password' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 25
            ]
        ]
    ];
}
