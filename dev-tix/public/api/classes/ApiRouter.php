<?php

require_once __DIR__ . '/AbsApiController.php';
require_once __DIR__ . '/../helpers/ApiMessage.php';
require_once __DIR__ . '/ApiRoutes.php';

class ApiRouter
{
    private static string $method;
    private static object $controller;

    public static function getResponse(string $method, array $data)
    {
        $page = $data['page'];
        $id = $data['id'] ?? 0;

        // Guard clause.
        if (!in_array($page, ApiRoutes::ROUTES[$method])) {
            return Encode::toJSON(ApiMessage::invalidRoute());
        }

        // Set request method.
        self::$method = $method;

        // Instantiate appropriate controller.
        $className = ucfirst($page) . 'ApiController';
        require_once __DIR__ . "/../controllers/{$className}.php";
        self::$controller = new $className();

        // Return JSON response.
        header('Content-Type: application/json');
        return Encode::toJSON(self::proccessRequest($data, $id));
    }

    private static function proccessRequest(array $data, int $id)
    {
        $return = [];
        switch (self::$method) {
            case 'GET':
                if ($id !== 0) {
                    self::$controller->setId($id);
                }

                $return = self::$controller->get();

                break;
            case 'POST':
                if (empty($data)) {  // Guard clause.
                    return Encode::toJSON(ApiMessage::invalidData());
                }

                self::$controller->setData($data);
                $return = self::$controller->post();

                break;
            case 'PUT':
                if ($id === 0) {  // Guard clauses.
                    return Encode::toJSON(ApiMessage::invalidId());
                } else if (empty($data)) {
                    return Encode::toJSON(ApiMessage::invalidData());
                }

                self::$controller->setId($id);
                self::$controller->setData($data);
                $return = self::$controller->put();

                break;
            case 'DELETE':
                if ($id === 0) {  // Guard clause.
                    return Encode::toJSON(ApiMessage::invalidId());
                }

                self::$controller->setId($id);
                $return = self::$controller->delete();

                break;
        }

        return $return;
    }
}
