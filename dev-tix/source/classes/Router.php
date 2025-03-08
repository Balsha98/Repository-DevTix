<?php

require_once __DIR__ . '/Routes.php';

class Router
{
    /**
     * Render teh page based on the uri.
     * @param string $uri - request uri.
     * @return - approprate view.
     */
    public static function renderPage(string $uri)
    {
        if ($uri === '/') {
            $page = 'welcome';
        } else {
            $uri = explode('/', $uri);
            if (!in_array($uri[0], Routes::ROUTES)) {
                return self::requireView('invalid-route');
            } else if (count($uri) === 2) {
                [1 => $id] = $uri;
            }

            [0 => $page] = $uri;
        }

        // Session check.
        Session::start();
        if ($page === 'login' || $page === 'signup') {
            if (Session::isSet('active')) {
                Redirect::toRoute('/dashboard');
            }
        } else if ($page === 'logout') {
            if (Session::isSet('active')) {
                Session::stop();
            }

            Redirect::toRoute('/login');
        }

        // Render target page.
        return self::requireView($page);
    }

    /**
     * Get view contents.
     * @param string $page - allowed view name.
     * @return - appropriate view.
     */
    private static function requireView(string $page)
    {
        ob_start();

        // Bind the page with the partials.
        require_once __DIR__ . '/../../public/core/views/partials/header.php';
        require_once __DIR__ . "/../../public/core/views/{$page}.php";
        require_once __DIR__ . '/../../public/core/views/partials/footer.php';

        return ob_get_clean();
    }
}
