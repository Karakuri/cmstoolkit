<?php

// デフォルトでエラーを例外に変換
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");

include 'paths.php';
include APP_PATH . DS . 'env.php';
include APP_PATH . DS . 'vendor' . DS . 'autoload.php';
