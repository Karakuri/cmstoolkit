<?php

namespace core\view;

use core\File;

use core\Controller;

class BinaryView implements Instance {
	public function init() {}
	
	public function render($options, Controller $controller) {
		return File::exec(VIEW_PATH, $options['path'], array('controller' => $controller));
	}
}