<?php

namespace core\snippets;

use core\Controller;

class TestSnippet extends Instance {
	public function init() {}
	
	public function test() {
		return 'this is snippet for test!';
	}
}