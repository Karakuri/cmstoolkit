<?php

namespace core\cache;

class ApcCache implements Instance {
	public function get($key) {
		return apc_fetch($key);
	}
	
	public function set($key, $value) {
		apc_store($key, $value);
	}
	
	public function isExists($key) {
		return apc_exists($key);
	}
	
	public function remove($key) {
		apc_delete($key);
	}
	
	public function clear() {
		apc_clear_cache('user');
	}
}