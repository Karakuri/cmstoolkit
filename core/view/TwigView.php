<?php

namespace core\view;

use core\Config;
use core\Controller;

class TwigView implements Instance {
	private $loader;
	private $twig;
	
	public function init() {
		$this->loader = new \Twig_Loader_Filesystem(VIEW_PATH);
		$this->twig = new \Twig_Environment($this->loader,array(
			'cache' => Config::get('twig.cache_path')
		));
		$this->twig->addTokenParser(new Project_Snippet_TokenParser());
		$this->twig->addTokenParser(new Project_Js_TokenParser());
	}
	
	public function render($options, Controller $controller) {
		$metaFunc = new Twig_SimpleFunction('meta', array($controller,'getMetadata'));
		$paramFunc = new Twig_SimpleFunction('param', array($controller,'getParameter'));
		$routeParamFunc = new Twig_SimpleFunction('route_param', array($controller,'getRouteParameter'));
		$cookieFunc = new Twig_SimpleFunction('cookie', array($controller,'getCookie'));
		$snippetFunc = new Twig_SimpleFunction('snippet', array($controller,'getSnippet'));
		
		$this->twig->addFunction($metaFunc);
		$this->twig->addFunction($paramFunc);
		$this->twig->addFunction($routeParamFunc);
		$this->twig->addFunction($cookieFunc);
		$this->twig->addFunction($snippetFunc);
		
		return $this->twig->render($options['path'], array(
				'controller' => $controller
				);
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
		
		if ($stream->test('as')) {
			$stream->next();
			$alias = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();
		}

		$this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

		return new Project_Snippet_Node($name, $alias, $lineno, $this->getTag());
	}

	public function getTag()
	{
		return 'snippet';
	}
}

class Project_Snippet_Node extends \Twig_Node
{
	public function __construct($name, $alias, $lineno, $tag = null)
	{
		parent::__construct(array(), array('name' => $name, 'alias' => $alias), $lineno, $tag);
	}

	public function compile(\Twig_Compiler $compiler)
	{
		$compiler
		->addDebugInfo($this)
		->write('core\\Snippet::get(\''.$this->getAttribute('name').'\')->_init(\''.($this->getAttribute('alias') ?: $this->getAttribute('name')).'\', $context[\'controller\']);' . "\n")
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