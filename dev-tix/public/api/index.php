<?php
require_once __DIR__ . '/classes/ApiRouter.php';

$input = Encode::fromJSON(file_get_contents('php://input')) ?? [];
echo ApiRouter::getResponse($_SERVER['REQUEST_METHOD'], $input);
