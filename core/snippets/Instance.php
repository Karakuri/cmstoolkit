<?php

namespace core\snippets;

use core\Controller;

abstract class Instance {

    private $controller;
    private $name;

    public function _init($name, Controller $controller) {
        $this->name = $name;
        $this->controller = $controller;
        $controller->registerSnippet($name, $this);

        $this->init();
    }

    protected function registerEvent($name, $callable) {
        $this->controller->registerEvent($name, $callable);
    }

    public function getOption($key, $orElse = null) {
        $name = $this->name;
        return $this->controller->getMetadata("snippets.$name.options.$key", $orElse);
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

    abstract function init();
}