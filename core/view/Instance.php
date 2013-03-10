<?php

namespace core\view;

use core\Controller;

interface Instance {
	public function init();
	public function render($options, Controller $controller);
}