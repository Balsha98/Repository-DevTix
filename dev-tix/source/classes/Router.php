<?php

require_once __DIR__ . '/Routes.php';
require_once __DIR__ . '/helpers/Debug.php';

class Router
{
    public static function renderPage(string $url)
    {
        if ($url === '/') {
            $page = 'login';
        } else {
            $uri = explode('/', $url);
            if (!in_array($uri[0], Routes::ROUTES)) {
                return self::require('invalid-route');
            }

            [$page] = $uri;
        }

        ob_start();

        self::require($page);

        return ob_get_clean();
    }

    private static function require(string $page)
    {
        require_once __DIR__ . '/../../public/core/views/partials/header.php';
        require_once __DIR__ . "/../../public/core/views/{$page}.php";
        require_once __DIR__ . '/../../public/core/views/partials/footer.php';
    }
}
