<?php

namespace core;

class Auth {
	private static $instances = array();
	
	private static function wrench($name = 'default') {
		if (!array_key_exists($name, self::$instances)) {
			$cl = Config::get("config.auth.$name.class");
			$className = Config::get("auth.$cl");
			
			self::$instances[$name] = new $className($name, Config::get("config.auth.$name"));
		}
		
		return self::$instances[$name];
	}
}