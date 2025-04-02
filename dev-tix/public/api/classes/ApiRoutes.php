<?php

class ApiRoutes
{
    public const ROUTES = [
        'GET' => [
            'dashboard',
            'leaderboard',
            'navigation',
            'profile',
            'ticket',
            'tickets',
            'users'
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
        'DELETE' => [
            'profile'
        ],
    ];
}
