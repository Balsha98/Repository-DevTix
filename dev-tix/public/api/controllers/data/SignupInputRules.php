<?php

class SignupInputRules
{
    // Constants.
    public const RULES = [
        'first_name' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 30
            ],
        ],
        'last_name' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 30
            ],
        ],
        'email' => [
            'type' => 'email',
            'required' => true,
        ],
        'age' => [
            'type' => 'int',
            'required' => false,
            'length' => [
                'min' => 1,
                'max' => 100
            ]
        ],
        'username' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 25
            ],
        ],
        'password' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 8,
                'max' => 25
            ]
        ]
    ];
}
