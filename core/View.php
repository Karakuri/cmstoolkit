<?php 

namespace core;

class View {
	private static $instance;
	
	private static function init() {
		if (!self::$instance) {
			$viewName = Config::get('config.view');
			$className = Config::get("view.$viewName");
			self::$instance = new $className;
			self::$instance->init();
		}
	}
	
	public static function render($path, $controller) {
		self::init();
		return self::$instance->render($path, $controller);
	}
}