<?php

namespace core\credentials;

use core\Arr;

abstract class Instance {
    private $parameters = array();
    
    public function setParameter($key, $value) {
        $this->parameters[$key] = $value;
    }
    
    protected function getParameter($key, $orElse = null) {
        return Arr::get($this->parameters, $key, $orElse);
    }
    
    abstract function getRequiredKeys();
	abstract function getIdentifier();
	abstract function getPayload();
}