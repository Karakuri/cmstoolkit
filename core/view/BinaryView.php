<?php

namespace core\view;

use core\File;

use core\Controller;

class BinaryView implements Instance {
	public function init() {}
	
	public function render($path, Controller $controller) {
		return File::exec(VIEW_PATH, $path, array('controller' => $controller));
	}
}