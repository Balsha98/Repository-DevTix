<?php

require_once __DIR__ . '/ApiRoutes.php';

class ApiRouter
{
    public static function echoResponse(string $method, array $data)
    {
        $page = $data['page'];

        // Guard clause.
        if (!in_array($page, ApiRoutes::ROUTES[$method])) {
            return Encode::toJSON(['error' => 'Invalid API route.']);
        }
    }
}
