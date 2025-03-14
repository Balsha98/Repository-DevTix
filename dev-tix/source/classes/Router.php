<?php
require_once __DIR__ . '/Routes.php';

class Router
{
    /**
     * Render teh page based on the uri.
     * @param string $uri - request uri.
     * @return - appropriate view.
     */
    public static function renderPage(string $uri)
    {
        Session::start();

        // Check CSRF token expiration.
        self::refreshAuthTokenIfValid();

        // Parse uri.
        if ($uri === '/') {
            $page = 'welcome';
        } else {
            Session::set('record_id', 0);
            $uri = explode('/', $uri);
            if (!in_array($uri[0], Routes::ROUTES)) {
                return self::requireView('invalid-route');
            } else if (count($uri) === 2) {
                Session::set('record_id', $uri[1]);
            }

            $page = $uri[0];
        }

        // Session verification.
        Session::set('last_route', "/{$page}");
        self::confirmTraffic($page);

        // Render target page.
        return self::requireView($page);
    }

    /**
     * Generates a new CSRF token if valid.
     * @return void void - executes the process.
     */
    private static function refreshAuthTokenIfValid()
    {
        if (Session::isSet('csrf_token')) {
            if (((time() - Session::get('csrf_token_set_at')) / 60) > 5) {
                if (Session::get('active')) {
                    Session::setAuthToken('sha256', 'jagshemash');
                }
            }
        }
    }

    /**
     * Verifies user activity and redirects traffic.
     * @param string $page - requested page/view.
     * @return void void - executes the process.
     */
    private static function confirmTraffic(string $page)
    {
        if ($page === 'login' || $page === 'signup') {
            if (Session::isSet('active')) {
                Redirect::toRoute('/dashboard');
            }
        } else if ($page === 'logout') {
            if (Session::isSet('active')) {
                Session::stop();
            }

            Redirect::toRoute('/login');
        } else if ($page !== 'welcome') {
            if (!Session::isSet('active')) {
                Redirect::toRoute('/login');
            }
        }
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
