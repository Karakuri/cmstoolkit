<?php

namespace core;

class Cache {
	private static $instances = array();
	
	private static function wrench($name = 'default') {
		if (!array_key_exists($name, self::$instances)) {
			$cl = Config::get("config.cache.$name.class");
			$className = Config::get("cache.$cl");
			
			self::$instances[$name] = new $className;
		}
		
		return self::$instances[$name];
	}
}