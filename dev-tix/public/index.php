<?php
require_once __DIR__ . '/../source/classes/Router.php';
echo Router::renderPage($_GET['uri'] ?? '/');
