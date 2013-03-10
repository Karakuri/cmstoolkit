<?php


namespace core\filters;

use core\Controller;

abstract class Instance {
	private $controller;
	
	public function init(Controller $controller) {
		$this->controller = $controller;
	}
	
	protected function getController() {
		return $this->controller;
	}
}