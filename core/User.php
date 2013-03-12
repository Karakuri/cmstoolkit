<?php

namespace core;

class User {
	private $userInfo;
	
	public function __construct($id, $userInfo) {
		$this->id = $id;
		$this->userInfo = $userInfo;
	}
	
	public function getUserInfo($key, $orElse = false) {
		return Arr::get($this->userInfo, $key, $orElse);
	}
	
	public function setUserInfo($key, $value) {
		Arr::set($this->userInfo, $key, $value);
	}
}