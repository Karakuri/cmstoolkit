<?php

namespace core\view;

use core\Controller;

abstract class Instance {
	private $path;
	
	public function __construct($path) {
		$this->path = $path;
		$this->init();
	}
	
	public function getPath() {
		return $this->path;
	}
	
	abstract function init();
	abstract function render(Controller $controller);
}