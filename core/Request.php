<?php

namespace core;

class Request {
	static function getPathArray() {
		static $path;

		$reqUri = self::getPath();
		$path = explode('/', $reqUri);

		return $path;
	}
	
	static function getPath() {
		static $reqUri;

		$reqUri = substr($_SERVER['REQUEST_URI'], 1);
		if (false !== ($hashPos = strpos($reqUri, '?'))) {
			$reqUri = substr($reqUri, 0, $hashPos);
		}
		
		if (false !== ($queryPos = strpos($reqUri, '?'))) {
			$reqUri = substr($reqUri, 0, $queryPos);
		}
		
		return $reqUri;
	}
}
