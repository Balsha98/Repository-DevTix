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
            'profile',
            'ticket',
            'welcome'
        ],
        'PUT' => [
            'navigation',
            'profile',
            'ticket'
        ],
        'DELETE' =>
            'profile',
    ];
}
