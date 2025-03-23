<?php
require_once __DIR__ . '/AbsApiController.php';
require_once __DIR__ . '/../helpers/ApiMessage.php';
require_once __DIR__ . '/ApiRoutes.php';

class ApiRouter
{
    // Attributes.
    private static string $method;
    private static object $controller;

    /**
     * Get response based on the request.
     * @param string $method - API request method.
     * @param array $data - input data.
     * @return string - JSON formatted response.
     */
    public static function getResponse(string $method, array $data)
    {
        $id = $data['id'] ?? 0;
        if ($method === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        [$directory, $script] = self::parseRoute($data);

        // Guard clause: check if route is valid.
        if (!in_array($script, ApiRoutes::ROUTES[$method])) {
            return Encode::toJSON(ApiMessage::apiError('route'));
        }

        // Start session.
        Session::start();

        // Guard clause: check CSRF token.
        if ($script !== 'login' && $script !== 'signup') {
            $authToken = self::extractToken($data);

            if ($authToken !== Session::get('csrf_token') ||
                    ((time() - Session::get('csrf_token_set_at')) / 60) > 5) {
                return Encode::toJSON(ApiMessage::apiError('token'));
            }
        }

        // Set request method.
        self::$method = $method;

        // Instantiate appropriate controller.
        $className = ucfirst($script) . 'ApiController';
        require_once __DIR__ . "/../controllers/{$directory}/{$className}.php";
        self::$controller = new $className();

        // Return JSON response.
        header('Content-Type: application/json');
        return Encode::toJSON(self::processRequest($id, $data));
    }

    private static function parseRoute(array $data)
    {
        $route = '';
        if (isset($data['route'])) {  // Regular POST, PUT, DELETE requests.
            $route = $data['route'];
        } else if (isset($_GET['route'])) {  // GET request via url.
            $route = $_GET['route'];
        } else if (isset($_POST['route'])) {  // Image upload requests.
            $route = $_POST['route'];
        }

        // Separate the url resources.
        return explode('/', $route);
    }

    private static function extractToken(array $data)
    {
        $token = '';
        if (isset($data['csrf_token'])) {
            $token = $data['csrf_token'];
        } else if (isset($_GET['csrf_token'])) {
            $token = $_GET['csrf_token'];
        } else if (isset($_POST['csrf_token'])) {
            $token = $_POST['csrf_token'];
        }

        // Get token.
        return $token;
    }

    /**
     * Process API request.
     * @param array $data - input data.
     * @param int $id - record id.
     */
    private static function processRequest(int $id, array $data)
    {
        return match (self::$method) {
            'GET' => self::processGET($id),
            'POST' => self::processPOST($data),
            'PUT' => self::processPUT($id, $data),
            'DELETE' => self::processDELETE($id)
        };
    }

    /**
     * Process GET requests.
     * @param int $id - record id.
     */
    private static function processGET(int $id)
    {
        if ($id !== 0) {
            self::$controller->setId($id);
        }

        // Return API response.
        return self::$controller->get();
    }

    /**
     * Process POST request.
     * @param array $data - input data.
     */
    private static function processPOST(array $data)
    {
        // Guard clause: empty input data.
        if (empty($data) && empty($_POST)) {
            return ApiMessage::apiError('input');
        }

        // Regular POST request or POST for image uploads.
        self::$controller->setData(!empty($data) ? $data : $_POST);

        // Return API response.
        return self::$controller->post();
    }

    /**
     * Process PUT requests.
     * @param int $id - record id.
     * @param array $data - input data.
     */
    private static function processPUT(int $id, array $data)
    {
        if ($id === 0) {  // Guard clause.
            return ApiMessage::apiError('id');
        } else if (empty($data)) {  // Guard clause.
            return ApiMessage::apiError('input');
        }

        self::$controller->setId($id);
        self::$controller->setData($data);

        // Return API response.
        return self::$controller->put();
    }

    /**
     * Process DELETE requests.
     * @param int $id - record id.
     */
    private static function processDELETE(int $id)
    {
        if ($id === 0) {  // Guard clause.
            return ApiMessage::apiError('id');
        }

        self::$controller->setId($id);

        // Return API response.
        return self::$controller->delete();
    }
}
