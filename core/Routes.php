<?php

namespace core;

class Routes {
	private $parameters = array();
	private $method = null;
	private $path;
	private $pagePath;
	
	public function __construct($path, $pagePath) {
		$this->method = 'GET';
		foreach (array('GET', 'POST', 'PUT', 'DELETE', 'HEAD') as $method) {
			if (strpos($path, $method . ' ') === 0) {
				$this->method = $method;
				$path = substr($path, strlen($method . ' '));
				break;
			}
		}
		$path = str_replace('/', '\/', $path);
		$this->path = preg_replace_callback("/([:*])([a-zA-Z0-9_]+)/u", array($this, 'addParameter'), $path);
		$this->pagePath = $pagePath;
	}
	
	public function addParameter($matches) {
		$this->parameters[$matches[2]] = null;
		
		return $matches[1] == ':' ? '([^\/]+)' : '(.+)';
	}
	
	public function getParameter($key = null, $orElse = null) {
		return $key !== null ? Arr::get($this->parameters, $key, $orElse) : $this->parameters;;
	}
	
	public function getPagePath() {
		return $this->pagePath;
	}
	
	public function match($uri, $method = null) {
		if ($method !== null && $this->method !== $method) {
			return false;
		}
		
		if ($uri == '') {
			$uri = "index";
		}
		$result = preg_match('/^' . $this->path . '$/u', $uri, $matches);
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
	
	static function get($uri, $method = null) {
		$routes = Config::get('routes');
		
		foreach ($routes as $path => $dest) {
			$instance = new self($path, $dest);
			
			if ($instance->match($uri, $method)) {
				return $instance;
			}
		}
		
		return self::get404($uri);
	}
	
	static function get404($uri) {
		return new self($uri, '/error/404');
	}
}