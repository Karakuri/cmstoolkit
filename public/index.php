<?php

use core\Request;
use core\Controller;

include '../bootstrap.php';

$controller = new Controller(Request::getPath());
echo $controller->renderPage();