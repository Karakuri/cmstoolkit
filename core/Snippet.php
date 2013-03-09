<?php

namespace core;

class Snippet {
	public static function get($name) {
		$snippets = Config::get('snippet');
		
		if (array_key_exists($name, $snippets)) {
			$className = $snippets[$name];
			
			$instance = new $className;
			return $instance;
		}
		return null;
	}
}