<?php

namespace core\snippets;

use core\snippets\Instance;

class IncludeAssetsSnippet extends Instance {
	private $js = array();
	private $css = array();
	
	public function init() {
		$this->getController()->registerEvent('postRender', array($this, 'onPostRender'));
	}
	
	public function addJs($src) {
		$this->js[] = $src;
	}
	
	public function addCss($href) {
		$this->css[] = $href;
	}
	
	public function onPostRender($html, $result) {
		$scripts = '';
		foreach ($this->js as $src) {
			$scripts .=  '<script src="' . $src . '"></script>' . "\n";
		}
		
		if ($result) $html = $result;
		$html = str_replace('</body>', $scripts . '</body>', $html);
		return $html;
	}
}