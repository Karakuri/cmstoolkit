<?php

namespace core;

class Attributes {
	private $attributes = array();
	
	public function get($key, $orElse = null) {
		return Arr::get($this->attributes, $key, $orElse);
	}
	
	public function set($key, $value) {
		Arr::setRecursive($this->attributes, $key, $value);
	}
}