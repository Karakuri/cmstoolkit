<?php

namespace core\snippets;

use core\Controller;
use core\View;
use core\Arr;

abstract class Instance {

    private $controller;
    private $name;
    private $options;

    public function _init($name, Controller $controller, $options = null) {
        $this->name = $name;
        $this->controller = $controller;
        $controller->registerSnippet($name, $this);
        
        if ($options !== null) {
            $this->options = $options;
        } else {
            $this->options = $this->controller->getMetadata("snippets.$name.options", array());
        }

        $this->init();
    }
    
    public function getController() {
    	return $this->controller;
    }

    public function getOption($key, $orElse = null) {
        return Arr::get($this->options, $key, $orElse);
    }
    
    public function render($path, $type = null) {
        $view = View::wrench($path, $type);
        return $view->render($this);
    }

    abstract function init();
}