<?php 

namespace core;

class Config {
	static $conf = array();
	
	static function get($key, $orElse = null) {
		if (false !== ($firstSep = strpos($key, '.'))) {
			$filename = substr($key, 0, $firstSep);
			$key = substr($key, $firstSep + 1);
		} else {
			$filename = $key;
			$key = null;
		}
		
		if (!array_key_exists($filename, self::$conf)) {
			self::loadFile($filename);
		}
		
		if ($key === null) {
			return self::$conf[$filename];
		}
		
		return Arr::get(self::$conf[$filename], $key, $orElse);
	}
	
	static private function loadFile($filename) {
		if (File::isFile(File::join(CONFIG_PATH, ENVIRONMENT), $filename . '.php')) {
			self::$conf[$filename] = File::exec(File::join(CONFIG_PATH, ENVIRONMENT), $filename);
			return;
		}
		self::$conf[$filename] = File::exec(CONFIG_PATH, $filename);
	}
}