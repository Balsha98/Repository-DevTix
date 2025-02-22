<?php

require_once __DIR__ . '/../../source/configuration.php';
require_once __DIR__ . '/../../source/classes/helpers/Debug.php';
require_once __DIR__ . '/../../source/classes/helpers/Encode.php';
require_once __DIR__ . '/../../source/classes/helpers/Session.php';
require_once __DIR__ . '/classes/ApiRouter.php';

echo ApiRouter::echoResponse(
    Encode::fromJSON(file_get_contents('php://input')),
    $_SERVER['REQUEST_METHOD']
);
