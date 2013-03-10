<?php

namespace core\filters;

class AssetsIncludeFilter extends Instance {
	public function onRender($html) {
		$scripts = $this->getController()->getAttribute("assets.js");
		
		$src = '';
		foreach ($scripts as $script) {
			$src .= '<script src="' . $script .'"></script>' . "\n";
		}
		$src .= '</body>';
		
		return str_replace('</body>', $src, $html);
	}
}