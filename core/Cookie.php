<?php

namespace core;

class Cookie {
	private $cookie;
	private $fromRequest;

	public function __construct($cookie, $fromRequqest = false) {
		$this->cookie = $cookie;
		$this->fromRequest = $fromRequest;
	}
	
	public function get($key, $orElse = null) {
		return Arr::get($this->cookie, $key, $orElse);
	}
	
	public static function getFromRequest() {
		return new self($_COOKIE, true);
	}
}