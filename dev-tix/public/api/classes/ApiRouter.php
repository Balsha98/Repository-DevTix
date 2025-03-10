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
     * Get reponse based on the request.
     * @param string $method - API request method.
     * @param array $data - input data.
     * @return string - JSON formatted response.
     */
    public static function getResponse(string $method, array $data)
    {
        $page = $data['page'] ?? $_GET['page'];
        $id = $data['id'] ?? 0;

        // Guard clause.
        if (!in_array($page, ApiRoutes::ROUTES[$method])) {
            return Encode::toJSON(ApiMessage::apiError('route'));
        }

        // Set request method.
        self::$method = $method;

        // Instantiate appropriate controller.
        $className = ucfirst($page) . 'ApiController';
        require_once __DIR__ . "/../controllers/{$className}.php";
        self::$controller = new $className();

        // Start session.
        Session::start();

        // Return JSON response.
        header('Content-Type: application/json');
        return Encode::toJSON(self::processRequest($id, $data));
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

    private static function processGET(int $id)
    {
        if ($id !== 0) {
            self::$controller->setId($id);
        }

        // Return API response.
        return self::$controller->get();
    }

    private static function processPOST(array $data)
    {
        if (empty($data)) {  // Guard clause.
            return Encode::toJSON(ApiMessage::apiError('input'));
        }

        self::$controller->setData($data);

        // Return API response.
        return self::$controller->post();
    }

    private static function processPUT(int $id, array $data)
    {
        if ($id === 0) {  // Guard clause.
            return Encode::toJSON(ApiMessage::apiError('id'));
        } else if (empty($data)) {  // Guard clause.
            return Encode::toJSON(ApiMessage::apiError('input'));
        }

        self::$controller->setId($id);
        self::$controller->setData($data);

        // Return API response.
        return self::$controller->put();
    }

    private static function processDELETE(int $id)
    {
        if ($id === 0) {  // Guard clause.
            return Encode::toJSON(ApiMessage::apiError('id'));
        }

        self::$controller->setId($id);

        // Return API response.
        return self::$controller->delete();
    }
}
