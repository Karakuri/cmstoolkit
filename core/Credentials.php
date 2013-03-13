<?php

namespace core;

class Credentials {
	public static function wrench($name = 'default') {
		$className = Config::get("credentials.$name");
		$instance = new $className;
		
		return $instance;
	}
}
