<?php

namespace core;

class Metadata {
	private $metadata = array();
	
	public function __construct($path) {
		$dir = '';
		$filename = $path;
		if (false !== ($lastSep = strrpos($path, '/'))) {
			$dir = str_replace('/', DS, substr($path, 0, $lastSep));
			$filename = substr($path, $lastSep + 1);
		}
		$this->metadata = File::exec(METADATA_PATH . $dir, $filename);
	}
	
	public function get($key = null, $orElse = null) {
		return $key !== null ? Arr::get($this->metadata, $key, $orElse) : $this->metadata;
	}
	
	static function load($path) {
		return new self($path);
	}
	
	static private function loadFile($filename) {
		self::$metadata[$filename] = File::exec(METADATA_PATH, $filename);
	}
}