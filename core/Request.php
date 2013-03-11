<?php

namespace core;

class Request {
	private $server;
	private $request;
	
	public function __construct($server = array(), $request = array()) {
		$this->server = $server;
		$this->request = $request;
	}
	
	public function getParameter($key, $orElse = null) {
		return Arr::get($request, $key, $orElse);
	}

	public function getPathArray() {
		static $path;

		$reqUri = $this->getPath();
		$path = explode('/', $reqUri);

		return $path;
	}
	
	public function getPath() {
		static $reqUri;

		$reqUri = substr($this->server['REQUEST_URI'], 1);
		if (false !== ($hashPos = strpos($reqUri, '?'))) {
			$reqUri = substr($reqUri, 0, $hashPos);
		}
		
		if (false !== ($queryPos = strpos($reqUri, '?'))) {
			$reqUri = substr($reqUri, 0, $queryPos);
		}
		
		return $reqUri;
	}
	
	static function getFromRequest() {
		return new self($_SERVER, $_REQUEST);
	}
}
