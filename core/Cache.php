<?php

namespace core;

class Cache {
	private static $instance = null;
	
	private static function init() {
		if (self::$instance === null) {
			$name = Config::get('config.cache');
			$className = Config::get("cache.$className");
			
			self::$instance = new $className;
		}
	}
	
	public static function get($key, $orElse = null) {
		self::init();
		return self::$instance->isExists($key) ? self::$instance->get($key) : $orElse;
	}
	
	public static function set($key, $value) {
		self::init();
		self::$instance->set($key, $value);
	}
	
	public static function isExists($key) {
		self::init();
		return self::$instance->isExists($key);
	}
	
	public static function remove($key) {
		self::init();
		self::$instance->remove($key);
	}
	
	public static function clear() {
		self::init();
		self::$instance->clear();
	}
}