<?php 

namespace core;

use core\snippets\Instance;

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
	
	public function getParameter($key = null) {
		return $key !== null ? $this->route->getParameter($key) : $this->route->getParameter();
	}
	
	public function getMetadata($key = null) {
		if (!$this->metadata) {
			$this->metadata = Metadata::load($this->getPagePath());
		}
		
		return $key !== null ? $this->metadata->get($key) : $this->metadata->get();
	}
	
	public function getPagePath() {
		return $this->route->getPagePath();
	}
	
	public function renderPage() {
		return View::render($this->getMetadata('view_path'), $this);
	}
}