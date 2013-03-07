<?php

namespace core;

class ClassLoader
{
	public static registerNamespace($name, string $path) {
		$cl = new SplClassLoader($name, $path);
		$cl->register();
	}
}