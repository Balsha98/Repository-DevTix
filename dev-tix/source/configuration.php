<?php

// Environment constants.
define('PROTOCOL', $_SERVER['REQUEST_SCHEME']);
define('SERVER_NAME', $_SERVER['SERVER_NAME']);
define('SERVER_PATH', PROTOCOL . '://' . SERVER_NAME);

// Database configurations.
define('DB_NAME', 'dev_tix');
define('DB_USER', 'root');
define('DB_PASS', '');
