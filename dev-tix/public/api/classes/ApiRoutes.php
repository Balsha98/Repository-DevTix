<?php

class ApiRoutes
{
    public const ROUTES = [
        'GET' => [
            'dashboard',
            'navigation',
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
