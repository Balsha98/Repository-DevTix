<?php

class ApiRoutes
{
    public const ROUTES = [
        'GET' => [
            'dashboard',
            'navigation',
            'profile',
            'ticket',
            'tickets'
        ],
        'POST' => [
            'login',
            'signup',
            'ticket',
            'welcome'
        ],
        'PUT' => [
            'navigation',
            'ticket'
        ],
        'DELETE' =>
            '',
    ];
}
