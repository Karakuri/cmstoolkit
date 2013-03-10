<?php

namespace core\snippets;

use core\Controller;

abstract class Instance {
	private $controller;
	
	public function _init($name, Controller $controller) {
		$this->controller = $controller;
		$controller->registerSnippet($name, $this);
		
		$this->init();
	}
	
	public function getController() {
		return $this->controller;
	}
	
	abstract function init();	
}