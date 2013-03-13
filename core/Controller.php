<?php 

namespace core;

use core\snippets\Instance;

class Controller {
	private $route;
	private $metadata;
	private $attributes;
	private $request;
	private $snippets = array();
	private $events = array();
	private $responseCode = 200;

	public function __construct(Request $request) {
		$this->request = $request;
		$this->route = Routes::get($request->getPath(), $this->request->getMethod());
		$this->metadata = Metadata::load($this->getPagePath());
		$this->attributes = new Attributes();

		$this->responseCode = $this->getMetadata('responseCode', 200);

		foreach ($this->metadata->get('snippets', array()) as $name => $val) {
			if (!array_key_exists('preload', $val)) {
				continue;
			}

			$class = $val['preload'];

			$snippet = Snippet::get($class);
			$snippet->_init($name, $this);
		}
	}

	public function getParameter($key = null, $orElse = null) {
		return $this->request->getParameter($key, $orElse);
	}

	public function getCookie($key = null, $orElse = null) {
		return $this->request->getCookie($key, $orElse);
	}

	public function setCookie($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false) {
		setCookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}

	public function getRouteParameter($key = null, $orElse = null) {
		return $this->route->getParameter($key, $orElse);
	}

	public function getMethod() {
		return $this->request->getMethod();
	}

	public function getMetadata($key = null, $orElse = null) {
		return $this->metadata->get($key, $orElse);
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
		$view = View::wrench($this->getMetadata('view.path'), $this->getMetadata('view.type'));
		$this->callEvent('preRender', array($view));
		$result = $view->render($this);
		$filtered = $this->callEvent('postRender', array($result));
		header('HTTP', true, $this->responseCode);
		return $filtered !== null ? $filtered : $result;
	}

	public function setResponseCode($code) {
		$this->responseCode = $code;
	}

	public function redirect($uri, $status = 303) {
		throw new RedirectException($uri, $status);
	}

	public function registerEvent($name, $callable) {
		if (!is_callable($callable)) {
			throw new InvalidCallableException();
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