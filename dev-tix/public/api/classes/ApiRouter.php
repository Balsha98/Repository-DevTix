<?php
require_once __DIR__ . '/../helpers/ApiMessage.php';
require_once __DIR__ . '/../../../source/classes/handlers/Autoload.php';
require_once __DIR__ . '/../../../source/classes/helpers/Debug.php';
require_once __DIR__ . '/../../../source/classes/handlers/Session.php';
require_once __DIR__ . '/../../../source/classes/helpers/Encode.php';
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
        $id = (int) self::extractValue('id', $data) ?? 0;
        [$directory, $script] = self::extractValue('route', $data);

        // Guard clause: check if route is valid.
        if (!in_array($script, ApiRoutes::ROUTES[$method])) {
            return Encode::toJSON(ApiMessage::apiError('route'));
        }

        // Start session.
        Session::start();

        // Guard clause: invalid CSRF token.
        $authToken = self::extractValue('csrf_token', $data);
        if ($authToken !== Session::get('csrf_token') ||
                ((time() - Session::get('csrf_token_set_at')) / 60) > 5) {
            return Encode::toJSON(ApiMessage::apiError('token'));
        }

        // Set request method.
        self::$method = $method;

        // Include handler dependencies.
        Autoload::autoloadClassesPerRequest('api', $script);

        // Instantiate appropriate controller.
        $className = ucfirst($script) . 'ApiController';
        require_once __DIR__ . "/../controllers/{$directory}/{$className}.php";
        self::$controller = new $className();

        // Return JSON response.
        header('Content-Type: application/json');
        return Encode::toJSON(self::processRequest($id, $data));
    }

    private static function extractValue(string $key, array $data)
    {
        $return = '';
        if (isset($data[$key])) {  // Regular POST, PUT, DELETE requests.
            $return = $data[$key];
        } else if (isset($_GET[$key])) {  // GET request via url.
            $return = $_GET[$key];
        } else if (isset($_POST[$key])) {  // Image upload requests.
            $return = $_POST[$key];
        }

        // Get route.
        if (preg_match('#[/]#', $return)) {
            return explode('/', $return);
        }

        // Get id/token.
        return $return;
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
