<?php 

namespace core;

class View {

	public static function wrench($path, $type = null) {
		if ($type !== null) {
			$viewName = $type;
		} else {
			$viewName = Config::get('config.view');
		}
		$className = Config::get("view.$viewName");
		$instance = new $className($path);
		
		return $instance;
	}
}