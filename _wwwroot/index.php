<?php
require('core_path.php');
require(CORE_PATH . '/core.php');

import('core.routing');
$router = new \Core\Router;
$router->route(URI);
