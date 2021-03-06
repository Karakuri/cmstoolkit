<?php

namespace core;

class Session {
	private static $instance = null;
	
	private static function init() {
		if (self::$instance === null) {
			$name = Config::get('config.session.class');
			$className = Config::get("session.$name");
			
			self::$instance = new $className;
			
			session_set_save_handler(
				array(self::$instance, 'open'),
				array(self::$instance, 'close'),
				array(self::$instance, 'read'),
				array('core\Session', '_write'),
				array(self::$instance, 'destroy'),
				array(self::$instance, 'gc')
			);
			
			register_shutdown_function('session_write_close');
			session_start();
		}
	}
	
	public static function get($key, $orElse = null) {
		self::init();
		return Arr::get($_SESSION, $key, $orElse);
	}
	
	public static function set($key, $value) {
		self::init();
		Arr::set($_SESSION, $key, $value);
	}
	
	public static function rotate() {
		self::init();
		session_regenerate_id(false);
	}
	
	public static function _write($id, $data) {
		self::flushUserInfo();
		self::$instance->write($id, $data);
	}
	
	private static function flushUserInfo() {
		foreach (self::get('auth', array()) as $name => $user) {
			if ($user->needsFlush()) {
				Auth::wrench($name)->updateUserInfo($user->getId(), $user->getUserInfo());
			}
		}
	}
}