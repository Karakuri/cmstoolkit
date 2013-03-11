<?php

use core\Request;
use core\Controller;

include '../bootstrap.php';

try {
	$controller = new Controller(Request::getFromRequest());
	echo $controller->renderPage();
} catch (RedirectException $e) {
	header('Location: ' . $e->getMessage(), true, $e->getCode());
} catch (Exception $e) {
	throw $e;
}