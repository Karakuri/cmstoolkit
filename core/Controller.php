<?php 

namespace core;

use core\exceptions\PageNotFoundException;

class Controller {
	private $route;
	private $metadata;
	
	public function __construct($uri) {
		$this->route = Routes::get($uri);
		
		if (!$this->route) {
			throw new PageNotFoundException($uri);
		}
	}
	
	public function getParameter($key) {
		return $this->route->getParameter($key);
	}
	
	public function getMetadata($key) {
		if (!$this->metadata) {
			$this->metadata = Metadata::load($this->getPagePath());
		}
		
		return $this->metadata->get($key);
	}
	
	public function getPagePath() {
		return $this->route->getPagePath();
	}
}