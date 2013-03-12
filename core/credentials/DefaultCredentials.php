<?php

namespace core\credentials;

class DefaultCredentials extends Instance {
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
			'password' => hash('sha256', Config::get('salt') . $this->password)
		);
	}
}