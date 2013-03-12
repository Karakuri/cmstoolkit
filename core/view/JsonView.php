<?php

namespace core\view;

use core\File;
use core\Controller;

class JsonView extends Instance {
	public function init() {}
	
	public function render($controllerOrSnippet) {
		$array = File::exec(VIEW_PATH, $this->getPath, array('controller' => $controllerOrSnippet));
		return json_encode($array);
	}
}