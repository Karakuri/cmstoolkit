<?php

use core\Request;
use core\Controller;
use core\View;

include '../bootstrap.php';

try {
	$controller = new Controller(Request::wrenchFromRequest());
    $controller->callEvent('onPostInit');
	echo $controller->renderPage();
} catch (RedirectException $e) {
	header('Location: ' . $e->getMessage(), true, $e->getCode());
} catch (Exception $e) {
    $view = View::wrench('pages/error/500.html');
    $view->render(array('message' => $e->getMessage(), 'trace' => $e->getTraceAsString()));
}