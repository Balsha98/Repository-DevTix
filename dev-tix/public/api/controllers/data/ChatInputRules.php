<?php

class ChatInputRules
{
    // Constants.
    public const RULES = [
        'chat_message' => [
            'type' => 'str',
            'required' => true,
            'pattern' => 'special_cases',
            'length' => [
                'min' => 2,
                'max' => 250
            ]
        ],
    ];
}
