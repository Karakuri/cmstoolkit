<?php

namespace core\session;

interface Instance {
	function open($savePath, $sessionName);
	function close();
	function read($id);
	function write($id, $data);
	function destroy($id);
	function gc($maxlifetime);
}