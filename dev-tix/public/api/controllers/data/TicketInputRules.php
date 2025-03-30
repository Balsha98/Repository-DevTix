<?php

class TicketInputRules
{
    public const RULES = [
        'custom_type' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 50
            ]
        ],
        'subject' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 3,
                'max' => 50
            ]
        ],
        'question' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'special_cases',
            'length' => [
                'min' => 25,
                'max' => 250
            ]
        ],
        'response' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'special_cases',
            'length' => [
                'min' => 20,
                'max' => 200
            ]
        ],
    ];
}
