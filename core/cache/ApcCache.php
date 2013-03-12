<?php

namespace core\cache;

class ApcCache implements Instance {
	public function get($key, $orElse = null) {
		$res = apc_fetch($key);
		return $res !== false ? $res : $orElse;
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