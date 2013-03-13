<?php

namespace core\snippets;

use core\Credentials;
use core\Auth;
use core\exceptions\LoginIncorrectException;
use core\URL;

class LoginFormSnippet extends Instance {
	public function init() {
        $this->getController()->registerEvent('postInit', array($this, 'onPostInit'));
    }
    
    public function onPostInit() {
        if ($this->getController()->getMethod() == 'POST') {
            $credentials = Credentials::wrench($this->getOption('credentials'));
            foreach ($credentials->getRequiredKeys() as $key) {
                if ($this->getController()->getParameter($key) === null) return;
                $credentials->setParameter($key, $this->getController()->getParameter($key));
            }
            
            try {
                Auth::wrench($this->getOption('auth'))->login($credentials);
                if ($this->getOption('redirect_to') !== null) {
                    $this->redirect(URL::normalize($this->getOption('redirect_to'), 'http'));
                }
            } catch (LoginIncorrectException $e) {
                // do nothing
            }
        }
    }
}