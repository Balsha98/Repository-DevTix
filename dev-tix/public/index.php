<?php

require_once __DIR__ . '/../source/configuration.php';
require_once __DIR__ . '/../source/classes/helpers/Debug.php';
require_once __DIR__ . '/../source/classes/helpers/Session.php';
require_once __DIR__ . '/../source/classes/helpers/Encode.php';
require_once __DIR__ . '/../source/classes/helpers/Redirect.php';
require_once __DIR__ . '/../source/classes/helpers/Template.php';
require_once __DIR__ . '/../source/classes/helpers/Image.php';
require_once __DIR__ . '/../source/classes/helpers/Date.php';
require_once __DIR__ . '/../source/classes/Router.php';

echo Router::renderPage($_GET['uri'] ?? '/');
