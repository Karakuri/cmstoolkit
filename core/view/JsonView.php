<?php

namespace core\view;

use core\File;
use core\Controller;

class JsonView extends Instance {
	public function init() {}
	
	public function render(Controller $controller) {
		$array = File::exec(VIEW_PATH, $this->getPath, array('controller' => $controller));
		return json_encode($array);
	}
}