<?php

namespace core;

class Metadata {
	private $metadata = array();
	private $super = null;
	
	public function __construct($path) {
		$dir = '';
		$filename = $path;
		if (false !== ($lastSep = strrpos($path, '/'))) {
			$dir = str_replace('/', DS, substr($path, 0, $lastSep));
			$filename = substr($path, $lastSep + 1);
		}
		$this->metadata = File::exec(METADATA_PATH . $dir, $filename);
		
		if ($this->get('extends') !== null) {
			$this->super = self::load($this->get('extends'));
		}
	}
	
	public function get($key = null, $orElse = null) {
		if ($key === null) {
			return $this->metadata;
		}
		$res = Arr::get($this->metadata, $key, $orElse);
		if ($res === $orElse && $this->super) {
			$res = $this->super->get($key, $orElse);
		}
		return $res;
	}
	
	static function load($path) {
		return new self($path);
	}
	
	static private function loadFile($filename) {
		self::$metadata[$filename] = File::exec(METADATA_PATH, $filename);
	}
}