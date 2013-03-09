<?php

namespace core\snippets;

use core\Controller;

abstract class Instance {
	private $controller;
	
	public function init(Controller $controller) {
		$this->controller = $controller;
	}
	
	public function getController() {
		return $this->controller;
	}
	
	abstract function execute();
}