<?php

namespace core\view;

use core\File;

use core\Controller;

class AssetView implements Instance {
	public function init() {}
	
	public function render($options, Controller $controller) {
		$path = $controller->getParameter($options['key']);
		
		if (false !== ($lastSep = strrpos($path, '/'))) {
			$filename = substr($path, $lastSep + 1);
			$path = File::join(ASSETS_PATH, str_replace('/', DS, substr($path, 0, $lastSep)));
		} else {
			$filename = $path;
			$path = ASSETS_PATH;
		}
		
		return File::read($path, $filename);
	}
}