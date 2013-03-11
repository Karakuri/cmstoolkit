<?php

namespace core;

class Request {
	private $server;
	private $request;
	private $cookie;
	
	public function __construct($server = array(), $request = array(), $cookie = array()) {
		$this->server = $server;
		$this->request = $request;
	}
	
	public function getParameter($key = null, $orElse = null) {
		if ($key === null) {
			return $this->request;
		}
		return Arr::get($this->request, $key, $orElse);
	}
	
	public function getCookie($key = null, $orElse = null) {
		if ($key === null) {
			return $this->cookie;
		}
		return Arr::get($this->cookie, $key, $orElse);
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
		if (false !== ($hashPos = strpos($reqUri, '#'))) {
			$reqUri = substr($reqUri, 0, $hashPos);
		}
		
		if (false !== ($queryPos = strpos($reqUri, '?'))) {
			$reqUri = substr($reqUri, 0, $queryPos);
		}
		
		return $reqUri;
	}
	
	static function getFromRequest() {
		return new self($_SERVER, $_GET + $_POST, $_COOKIE);
	}
}
