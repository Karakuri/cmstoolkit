<?php

include 'paths.php';
include 'classes/SplClassLoader.php';
include 'classes/ClassLoader.php';

ClassLoader::registerNamespace(null , APP_PATH . 'classes/');
ClassLoader::registerNamespace('core', CORE_PATH . 'classes/');

