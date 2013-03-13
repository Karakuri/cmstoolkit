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

    protected function registerEvent($name, $callable) {
        $this->controller->registerEvent($name, $callable);
    }

    public function getOption($key, $orElse = null) {
        return Arr::get($this->options, $key, $orElse);
    }

    public function getCookie($key, $orElse = null) {
        return $this->controller->getAttribute($key, $orElse);
    }

    protected function getParameter($key, $orElse = null) {
        return $this->controller->getParameter($key, $orElse);
    }

    protected function getRouteParameter($key, $orElse = null) {
        return $this->controller->getRouteParameter($key, $orElse);
    }
    
    protected function getMethod() {
        return $this->controller->getMethod();
    }
    
    protected function redirect($uri, $status = 303) {
        $this->controller->redirect($uri, $status);
    }
    
    public function render($path, $type = null) {
        $view = View::wrench($path, $type);
        return $view->render($this);
    }

    abstract function init();
}