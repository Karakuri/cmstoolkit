<?php 

namespace core;

class View {
	
	public static function render($options, $controller) {
		if (array_key_exists('type', $options)) {
			$viewName = $options['type'];
		} else {
			$viewName = Config::get('config.view');
		}
		$className = Config::get("view.$viewName");
		$instance = new $className;
		$instance->init();
		return $instance->render($options['path'], $controller);
	}
}