<?php

namespace core\view;

use core\Config;
use core\Controller;

class TwigView extends Instance {
	private $loader;
	private $twig;

	public function init() {
		$this->loader = new \Twig_Loader_Filesystem(VIEW_PATH);
		$this->twig = new \Twig_Environment($this->loader,array(
				'cache' => Config::get('twig.cache_path')
		));
		$this->twig->addTokenParser(new Project_Js_TokenParser());
		$this->twig->addTokenParser(new Project_Css_TokenParser());
		$this->twig->addTokenParser(new Project_Snippet_TokenParser());
	}

	public function render($controllerOrSnippet) {
		if ($controllerOrSnippet instanceof Controller) {
			return $this->twig->render($this->getPath(), array(
					'controller' => $controllerOrSnippet,
					'meta' => new TwigMetadataObject($controllerOrSnippet),
					'param' => new TwigParameterObject($controllerOrSnippet),
					'route_param' => new TwigRouteParameterObject($controllerOrSnippet),
					'cookie' => new TwigCookieObject($controllerOrSnippet),
					'snippet' => new TwigSnippetObject($controllerOrSnippet),
					'conf' => new TwigConfigObject(),
			));
		} else if ($controllerOrSnippet instanceof \core\snippets\Instance) {
			return $this->twig->render($this->getPath(), array(
					'controller' => $controllerOrSnippet->getController(),
					'this' => $controllerOrSnippet,
					'param' => new TwigParameterObject($controllerOrSnippet->getController()),
					'route_param' => new TwigRouteParameterObject($controllerOrSnippet->getController()),
					'option' => new TwigOptionObject($controllerOrSnippet),
					'cookie' => new TwigCookieObject($controllerOrSnippet->getController()),
					'conf' => new TwigConfigObject(),
					));
		} else if (is_array($controllerOrSnippet)) {
            return $this->twig->render($this->getPath(), $controllerOrSnippet);
        }
		
		throw new \InvalidArgumentException('view needs controller or snippet instance', 1, '');
	}
}

class TwigOptionObject {
	private $snippet;
	
	public function __construct(\core\snippets\Instance $snippet) {
		$this->snippet = $snippet;
	}
	
	public function __call($name, $arguments) {
		return $this->snippet->getOption($name);
	}
}

class TwigMetadataObject {
	private $controller;

	public function __construct(Controller $controller) {
		$this->controller = $controller;
	}

	public function __call($name, $arguments) {
		return $this->controller->getMetadata($name);
	}
}

class TwigParameterObject {
	private $controller;

	public function __construct(Controller $controller) {
		$this->controller = $controller;
	}

	public function __call($name, $arguments) {
		return $this->controller->getParameter($name);
	}
}

class TwigRouteParameterObject {
	private $controller;

	public function __construct(Controller $controller) {
		$this->controller = $controller;
	}

	public function __call($name, $arguments) {
		return $this->controller->getRouteParameter($name);
	}
}

class TwigCookieObject {
	private $controllerOrSnippet;

	public function __construct(Controller $controllerOrSnippet) {
		$this->controllerOrSnippet = $controllerOrSnippet;
	}

	public function __call($name, $arguments) {
		return $this->controllerOrSnippet->getCookie($name);
	}
}

class TwigSnippetObject {
	private $controller;

	public function __construct(Controller $controller) {
		$this->controller = $controller;
	}

	public function __call($name, $arguments) {
		return $this->controller->getSnippet($name);
	}
}

class TwigConfigObject {
	private $controller;

	public function __call($name, $arguments) {
		return Config::get($name);
	}
}

class Project_Snippet_TokenParser extends \Twig_TokenParser
{
	public function parse(\Twig_Token $token)
	{
		$stream = $this->parser->getStream();
		$lineno = $token->getLine();
		$name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
		$alias = null;
        $options = new \Twig_Node_Expression_Array(array(), $token->getLine());

		if ($stream->test('as')) {
			$stream->next();
			$alias = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
		}
        
        if ($stream->getCurrent()->getValue() == '{') {
            $options = $this->parser->getExpressionParser()->parseHashExpression();
        }

		$this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

		return new Project_Snippet_Node($name, $alias, $options, $lineno, $this->getTag());
	}

	public function getTag()
	{
		return 'snippet';
	}
}

class Project_Snippet_Node extends \Twig_Node
{
	public function __construct($name, $alias, $options, $lineno, $tag = null)
	{
		parent::__construct(array('options' => $options), array('name' => $name, 'alias' => $alias), $lineno, $tag);
	}

	public function compile(\Twig_Compiler $compiler)
	{
		$compiler
		->addDebugInfo($this)
		->write('core\\Snippet::get(\''.$this->getAttribute('name').'\')->_init(\''.($this->getAttribute('alias') ?: $this->getAttribute('name')).'\', $context[\'controller\'], ')
        ->subcompile($this->getNode('options'))
        ->raw(');' . "\n")
		;
	}
}

class Project_Js_TokenParser extends \Twig_TokenParser
{
	public function parse(\Twig_Token $token)
	{
		$stream = $this->parser->getStream();
		$lineno = $token->getLine();
		$src = $stream->expect(\Twig_Token::STRING_TYPE)->getValue();

		$this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

		return new Project_Js_Node($src, $lineno, $this->getTag());
	}

	public function getTag()
	{
		return 'js';
	}
}

class Project_Js_Node extends \Twig_Node
{
	public function __construct($src, $lineno, $tag = null)
	{
		parent::__construct(array(), array('src' => $src), $lineno, $tag);
	}

	public function compile(\Twig_Compiler $compiler)
	{
		$compiler
		->addDebugInfo($this)
		->write('if (null === ($snippet = $context[\'controller\']->getSnippet(\'include_assets\'))) { ' . "\n")
		->indent()
		->write('$snippet = core\\Snippet::get(\'include_assets\');' . "\n")
		->write('$snippet->_init(\'include_assets\', $context[\'controller\']);' . "\n")
		->outdent()
		->write('}')
		->write('$snippet->addJs(\'' . $this->getAttribute('src') . '\');' . "\n")
		;
	}
}

class Project_Css_TokenParser extends \Twig_TokenParser
{
	public function parse(\Twig_Token $token)
	{
		$stream = $this->parser->getStream();
		$lineno = $token->getLine();
		$href = $stream->expect(\Twig_Token::STRING_TYPE)->getValue();

		$this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

		return new Project_Css_Node($href, $lineno, $this->getTag());
	}

	public function getTag()
	{
		return 'css';
	}
}

class Project_Css_Node extends \Twig_Node
{
	public function __construct($href, $lineno, $tag = null)
	{
		parent::__construct(array(), array('href' => $href), $lineno, $tag);
	}

	public function compile(\Twig_Compiler $compiler)
	{
		$compiler
		->addDebugInfo($this)
		->write('if (null === ($snippet = $context[\'controller\']->getSnippet(\'include_assets\'))) { ' . "\n")
		->indent()
		->write('$snippet = core\\Snippet::get(\'include_assets\');' . "\n")
		->write('$snippet->_init(\'include_assets\', $context[\'controller\']);' . "\n")
		->outdent()
		->write('}')
		->write('$snippet->addCss(\'' . $this->getAttribute('href') . '\');' . "\n")
		;
	}
}