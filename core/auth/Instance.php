<?php

namespace core\auth;

use core\Arr;

abstract class Instance {
	private $name;
	private $options;
	
	public function __construct($name, $options) {
		$this->name = $name;
		$this->options = $options;
		
		$this->init();
	}
	
	protected function getName() {
		return $this->name;
	}
	
	protected function getOption($key, $orElse = false) {
		return Arr::get($this->options, $key, $orElse);
	}
	
	abstract function init();
	abstract function getUser();
	abstract function login(\core\credentials\Instance $credentials, $force = false);
	abstract function createUser(\core\credentials\Instance $credentials, $userInfo);
	abstract function deleteUser($id);
	abstract function updateUserCredentials($id, \core\credentials\Instance $credentials);
	abstract function updateUserInfo($id, $userInfo);
}