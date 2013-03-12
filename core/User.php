<?php

namespace core;

class User {
	private $id;
	private $originalInfo;
	private $userInfo;
	
	public function __construct($id, $userInfo) {
		$this->id = $id;
		$this->originalInfo = $userInfo;
		$this->userInfo = $userInfo;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getUserInfo($key = null, $orElse = false) {
		return $key !== null ? Arr::get($this->userInfo, $key, $orElse) : $this->userInfo;
	}
	
	public function setUserInfo($key, $value) {
		Arr::set($this->userInfo, $key, $value);
	}
	
	public function needsFlush() {
		return serialize($this->originalInfo) != serialize($this->userInfo);
	}
	
	public function flush() {
		$this->originalInfo = $this->userInfo;
	}
}