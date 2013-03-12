<?php

namespace core;

class User implements \Serializable {
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
	
	public function serialize() {
		return serialize(array(
			'id' => $this->id;
			'userInfo' => $this->userInfo;
		));
	}
	
	public function unserialize($data) {
		$data = unserialize($data);
		$this->id = $data['id'];
		$this->originalInfo = $data['userInfo'];
		$this->userInfo = $data['userInfo'];
	}
}