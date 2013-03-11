<?php

namespace core\cache;

interface Instance {
	public function get($key, $orElse);
	public function set($key, $value);
	public function isExists($key);
	public function remove($key);
	public function clear();
}