<?php

namespace core;

class Arr {
	static function get(&$array, $path, $orElse = null) {
		if (!is_array($array)) {
			return $orElse;
		}
		
		$key = $path;
		if (false !== ($firstSep = strpos($path, '.'))) {
			$key = substr($path, 0, $firstSep);
			$path = substr($path, $firstSep + 1);
		}
		
		if (!array_key_exists($key, $array)) {
			return $orElse;
		}
		
		if (is_array($array[$key]) && $firstSep !== false) {
			return self::get($array[$key], $path, $orElse);
		}
		
		return $array[$key];
	}
	
	public static function set(&$array, $key, $value) {
		self::setRecursive($array, $key, $value);
	}
	
	private function setRecursive(&$array, $key, &$value) {
		if (false !== ($firstSep = strpos($key, '.'))) {
			$path = substr($key, 0, $firstSep);
			$key = substr($key, $firstSep + 1);
			
			if (!is_array($array[$path])) {
				$array[$path] = array();
			}
			
			self::setRecursive($array, $key, $value);
			return;
		}
		if ($key == '') {
			$array[] = $value;
			return;
		} 
		$array[$key] = $value;
	}
}