<?php 

namespace core;

use core\snippets\Instance;

use core\exceptions\PageNotFoundException;

class Controller {
	private $route;
	private $metadata;
	private $attributes;
	
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
	
	public function getPagePath() {
		return $this->route->getPagePath();
	}
	
	public function renderPage() {
		$result = View::render($this->getMetadata('view'), $this);
		return $result;
	}
}