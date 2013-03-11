<?php

namespace core;

use core\exceptions\FileNotFoundException;

class File {
	static function read($path, $name, $chunksize = 1024) {
		if (strrpos($path, DS) !== 0) {
			$path .= DS;
		}

		$filename = $path . $name;

		if (is_file($filename)) {
			$handle = fopen($filename,'r');
			$text = '';
			while (!feof($handle)) {
				$buffer = fread($handle, $chunksize);
				$text .= $buffer;
			}
			$status = fclose($handle);
			
			return $text;
		}

		throw new FileNotFoundException($filename);
	}
	
	static function exec($path, $name, $args = array(),$extension = 'php') {
		if (strrpos($path, DS) !== 0) {
			$path .= DS;
		}
		
		$filename = $path . $name . '.' . 'php';
		
		if (is_file($filename)) {
			extract($args);
			return (include $filename);
		}
		
		throw new FileNotFoundException($filename);
	}
	
	static function isFile($path, $name) {
		if (strrpos($path, DS) !== 0) {
			$path .= DS;
		}
		
		return is_file($path . $name);
	}
	
	static function join() {
		$paths = func_get_args();
		
		return implode(DS, $paths);
	}
}