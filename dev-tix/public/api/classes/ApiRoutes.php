<?php

class ApiRoutes
{
    public const ROUTES = [
        'GET' => [
            'chat',
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
            'chat',
            'login',
            'signup',
            'profile',
            'ticket',
            'welcome'
        ],
        'PUT' => [
            'logout',
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
