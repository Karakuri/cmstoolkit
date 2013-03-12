<?php

namespace core\credentials;

use core\Config;

class DefaultCredentials implements Instance {
	private $username;
	private $password;
	
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	public function getIdentifier() {
		return array('username' => $this->username);
	}
	
	public function getPayload() {
		return array(
			'username' => $this->username,
			'password' => hash('sha256', Config::get('config.salt') . $this->password)
		);
	}
}