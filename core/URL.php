<?php

namespace core;

class URL {
	public static function normalize($path, $scheme = '') {
		if (strpos($path, 'http://') === 0) {
			return $path;
		} else if (strpos($path, 'https://') === 0) {
			return $path;
		} else if (strpos($path, '//') === 0) {
			return $path;
		}
		
		$base = Config::get('config.base_url');
		if (strpos($base, 'http://') === 0) {
			$base = strpos($base, strlen('http://'));
		} else if (strpos($base, 'https://') === 0) {
			$base = strpos($base, strlen('https://'));
		} else if (strpos($path, '//') === 0) {
			$base = strpos($base, strlen('//'));
		} else {
			$base = $_SERVER['HTTP_HOST'] . '/' . $base . '/';
		}
		
		return ($scheme ? $scheme . ':' : '') . '//' . $base . $path;
	}
}