<?php

namespace core;

class Attributes {
	private $attributes = array();
	
	public function get($key, $orElse = null) {
		return Arr::get($this->attributes, $key, $orElse);
	}
	
	public function set($key, $value) {
		setRecursive($this->attributes, $key, $value);
	}
	
	private function setRecursive(&$array, $key, &$value) {
		if (false !== ($firstSep = strpos($key, '.'))) {
			$path = substr($key, 0, $firstSep);
			$key = substr($key, $firstSep + 1);
			
			if (!is_array($array[$path])) {
				$array[$path] = array();
			}
			
			setRecursive($array, $key, $value);
			return;
		}
		if ($key == '') {
			$array[] = $value;
			return;
		} 
		$array[$key] = $value;
	}
}