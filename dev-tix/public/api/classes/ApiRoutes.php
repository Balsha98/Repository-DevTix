<?php

class ApiRoutes
{
    public const ROUTES = [
        'GET' => [
            'dashboard',
            'leaderboard',
            'leagues',
            'logs',
            'navigation',
            'notifications',
            'profile',
            'statistics',
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
            'notifications',
            'profile',
            'ticket'
        ],
        'DELETE' => [
            'profile'
        ],
    ];
}
