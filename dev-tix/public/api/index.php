<?php

require_once __DIR__ . '/../../source/classes/helpers/Session.php';

// REMINDER: Check is user active to allow access.

require_once __DIR__ . '/../../source/configuration.php';
require_once __DIR__ . '/../../source/classes/helpers/Debug.php';
require_once __DIR__ . '/../../source/classes/helpers/Validate.php';
require_once __DIR__ . '/../../source/classes/helpers/Encode.php';
require_once __DIR__ . '/classes/ApiRouter.php';

// API resources.
$method = $_SERVER['REQUEST_METHOD'];
$input = Encode::fromJSON(file_get_contents('php://input'));
echo ApiRouter::getResponse($method, $input);
