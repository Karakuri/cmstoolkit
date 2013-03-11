<?php

namespace core\view;

use core\File;

use core\Controller;

class BinaryView extends Instance {
	public function init() {}
	
	public function render(Controller $controller) {
		return File::exec(VIEW_PATH, $this->getPath, array('controller' => $controller));
	}
}