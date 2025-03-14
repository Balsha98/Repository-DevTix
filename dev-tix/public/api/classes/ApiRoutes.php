<?php

class ApiRoutes
{
    public const ROUTES = [
        'GET' => [
            'dashboard',
            'navigation',
            'ticket',
            'tickets'
        ],
        'POST' => [
            'login',
            'signup',
            'welcome'
        ],
        'PUT' => [
            'navigation'
        ],
        'DELETE' =>
            '',
    ];
}
