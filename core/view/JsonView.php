<?php

namespace core\view;

use core\File;
use core\Controller;

class JsonView implements Instance {
	public function init() {}
	
	public function render($options, Controller $controller) {
		$array = File::exec(VIEW_PATH, $options['path'], array('controller' => $controller));
		return json_encode($array);
	}
}