<?php 

namespace core;

use core\snippets\Instance;

use core\exceptions\PageNotFoundException;

class Controller {
	private $route;
	private $metadata;
	private $attributes;
	private $snippets = array();
	private $events = array();
	
	public function __construct($uri) {
		$this->route = Routes::get($uri);
		
		if (!$this->route) {
			throw new PageNotFoundException($uri);
		}
		
		$this->attributes = new Attributes();
	}
	
	public function getParameter($key = null) {
		return $key !== null ? $this->route->getParameter($key) : $this->route->getParameter();
	}
	
	public function getMetadata($key = null) {
		if (!$this->metadata) {
			$this->metadata = Metadata::load($this->getPagePath());
		}
		
		return $key !== null ? $this->metadata->get($key) : $this->metadata->get();
	}
	
	public function getAttribute($key, $orElse = null) {
		return $this->attributes->get($key, $orElse);
	}
	
	public function setAttribute($key, $value) {
		$this->attributes->set($key, $value);
	}
	
	public function registerSnippet($name, Instance $snippet) {
		$this->snippets[$name] = $snippet;
	}
	
	public function getSnippet($name) {
		return array_key_exists($name, $this->snippets) ? $this->snippets[$name] : null;
	}
	
	public function getPagePath() {
		return $this->route->getPagePath();
	}
	
	public function renderPage() {
		$result = View::render($this->getMetadata('view'), $this);
		$result = $this->callEvent('postRender', array($result));
		return $result;
	}
	
	public function registerEvent($name, $callable) {
		if (!is_callable($callable)) {
			// TODO
			return;
		}
		
		$this->events[$name][] = $callable;
	}
	
	public function callEvent($name, $args = array()) {
		if (!array_key_exists($name, $this->events)) {
			return;
		}
		
		$result = null;
		foreach ($this->events[$name] as $callable) {
			$result = call_user_func_array($callable, array_merge($args, array($result)));
		}
		
		return $result;
	}
}