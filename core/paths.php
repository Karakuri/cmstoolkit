<?php

define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', realpath(__DIR__ . DS . '..' . DS));
define('CORE_PATH', APP_PATH . DS . 'core');
define('CORE_CLASSES_PATH', CORE_PATH . DS . 'classes');
define('CONFIG_PATH', APP_PATH . DS . 'config');
define('APP_CLASSES_PATH', APP_PATH . DS . 'classes');
define('CACHE_PATH', APP_PATH . DS . 'cache');
define('METADATA_PATH', APP_PATH . DS . 'metadata');
define('VIEW_PATH', APP_PATH . DS . 'views');
