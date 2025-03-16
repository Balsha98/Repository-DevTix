<?php

class TicketInputRules
{
    public const RULES = [
        'custom_type' => [
            'type' => 'str',
            'pattern' => 'only_letters',
            'length' => [
                'min' => 3,
                'max' => 50
            ]
        ],
        'subject' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 3,
                'max' => 50
            ]
        ],
        'question' => [
            'type' => 'str',
            'pattern' => 'no_symbols',
            'length' => [
                'min' => 25,
                'max' => 250
            ]
        ],
    ];
}
