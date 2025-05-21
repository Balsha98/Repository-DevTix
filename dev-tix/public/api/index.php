<?php
require_once __DIR__ . '/../../source/configuration.php';
require_once __DIR__ . '/../../source/classes/helpers/Debug.php';
require_once __DIR__ . '/../../source/classes/handlers/Session.php';
require_once __DIR__ . '/../../source/classes/handlers/Validate.php';
require_once __DIR__ . '/../../source/classes/handlers/Notification.php';
require_once __DIR__ . '/../../source/classes/helpers/Encode.php';
require_once __DIR__ . '/../../source/classes/helpers/Image.php';
require_once __DIR__ . '/../../source/classes/handlers/Log.php';
require_once __DIR__ . '/classes/ApiRouter.php';

// API resources.
$method = $_SERVER['REQUEST_METHOD'];
$input = Encode::fromJSON(file_get_contents('php://input'));
echo ApiRouter::getResponse($method, $input ?? []);
