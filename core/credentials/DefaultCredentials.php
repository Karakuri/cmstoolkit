<?php

namespace core\credentials;

use core\Config;

class DefaultCredentials extends Instance {
	
	public function getIdentifier() {
		return array('username' => $this->getParameter('username'));
	}
	
	public function getPayload() {
		return array(
			'username' => $this->getParameter('username'),
			'password' => hash('sha256', Config::get('config.salt') . $this->getParameter('password')),
		);
	}
    
    public function getRequiredKeys() {
        return array(
            'username',
            'password',
        );
    }
}