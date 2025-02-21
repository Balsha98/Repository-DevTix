<?php

require_once __DIR__ . '/../source/configuration.php';
require_once __DIR__ . '/../source/classes/helpers/Template.php';
require_once __DIR__ . '/../source/classes/Router.php';

echo Router::renderPage($_GET['request'] ?? '/');
