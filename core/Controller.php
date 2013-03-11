<?php 

namespace core;

use core\snippets\Instance;
use core\exceptions\PageNotFoundException;

class Controller {
	private $route;
	private $metadata;
	private $attributes;
	private $request;
	private $snippets = array();
	private $events = array();
	
	public function __construct(Request $request) {
		$this->request = $request;
		$this->route = Routes::get($request->getPath());
		$this->metadata = Metadata::load($this->getPagePath());
		
		if (!$this->route) {
			throw new PageNotFoundException($request->getPath());
		}
		
		$this->attributes = new Attributes();
		
		foreach ($this->metadata->get('snippets.preload', array()) as $val) {
			if (is_array($name)) {
				$name = $val[0];
				$alias = array_key_exists('as', $val) ? $val['as'] : $name;
			} else {
				$name = $val;
				$alias = $name;
			}
			$snippet = Snippet::get($name);
			$snippet->_init($alias, $this);
		}
	}
	
	public function getParameter($key, $orElse = null) {
		return $this->request->getParameter($key, $orElse);
	}

	public function getCookie($key = null, $orElse = null) {
		return $this->request->getCookie($key, $orElse);
	}
	
	public function setCookie($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false) {
		setCookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	public function getRouteParameter($key = null, $orElse = null) {
		return $key !== null ? $this->route->getParameter($key, $orElse) : $this->route->getParameter();
	}
	
	public function getMetadata($key = null, $orElse = null) {
		return $key !== null ? $this->metadata->get($key, $orElse) : $this->metadata->get();
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
	
	public function getSnippet($name = null) {
		if ($name === null) {
			return $this->snippets;
		}
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