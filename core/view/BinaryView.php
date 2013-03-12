<?php

namespace core\view;

use core\File;

use core\Controller;

class BinaryView extends Instance {
	public function init() {}
	
	public function render($controllerOrSnippet) {
		return File::exec(VIEW_PATH, $this->getPath, array('controller' => $controllerOrSnippet));
	}
}