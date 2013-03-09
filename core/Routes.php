<?php

namespace core;

class Routes {
	private $parameters = array();
	private $path;
	private $pagePath;
	
	public function __construct($path, $pagePath) {
		$path = str_replace('/', '\/', $path);
		$this->path = preg_replace_callback("/:([a-zA-Z0-9_]+)/u", array($this, 'addParameter'), $path);
		$this->pagePath = $pagePath;
	}
	
	public function addParameter($matches) {
		$this->parameters[$matches[1]] = null;
		
		return '([^\/]+)';
	}
	
	public function getParameter($key) {
		return Arr::get($this->parameters, $key);
	}
	
	public function getPagePath() {
		return $this->pagePath;
	}
	
	public function match($uri) {
		if ($uri == '') {
			$uri = "index";
		}
		$result = preg_match('/' . $this->path . '/u', $uri, $matches);
		if ($result > 0) {
			if (count($this->parameters) > 0) {
				$this->parameters = array_combine(array_keys($this->parameters), array_slice($matches, 1));
				foreach ($this->parameters as $key => $val) {
					$this->pagePath = str_replace(':' . $key, $val, $this->pagePath);
				}
			}
			return true;
		}
		return false;
	}
	
	static function get($uri) {
		$routes = Config::get('routes');
		
		foreach ($routes as $path => $dest) {
			$instance = new self($path, $dest);
			
			if ($instance->match($uri)) {
				return $instance;
			}
		}
		
		return null;
	}
}