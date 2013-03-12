<?php

namespace core\snippets;

use core\Controller;

abstract class Instance {
	private $controller;
	private $name;
	
	public function _init($name, Controller $controller) {
		$this->name = $name;
		$this->controller = $controller;
		$controller->registerSnippet($name, $this);
		
		$this->init();
	}
	
	protected function registerEvent($name, $callable) {
		$this->controller->registerEvent($name, $callable);
	}
	
	protected function getOption($key, $orElse = false) {
		$name = $this->name;
		return $this->controller->getMetadata("snippets.options.$name.$key", $orElse);
	}
	
	abstract function init();	
}