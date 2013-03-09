<?php

use core\Request;
use core\Controller;

include '../bootstrap.php';

$controller = new Controller(Request::getPath());
var_dump($controller->getParameter('id'));
var_dump($controller->getPagePath());