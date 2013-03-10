<?php

/* pages/index.html */
class __TwigTemplate_3ce6a043cd73f783c30fab7f4e48272d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context['snippets']['test'] = core\Snippet::get('test');
        $context['snippets']['test']->_init('test', $context['controller']);
        // line 2
        if (null === ($snippet = $context['controller']->getSnippet('include_assets'))) { 
            $snippet = core\Snippet::get('include_assets');
            $snippet->_init('include_assets', $context['controller']);
        }        $snippet->addJs('assets/js/test.js');
        // line 3
        echo "<!DOCTYPE html>
<html>
<head>
<meta charset=\"UTF-8\">
<title>";
        // line 7
        if (isset($context["meta"])) { $_meta_ = $context["meta"]; } else { $_meta_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_meta_, "title"), "html", null, true);
        echo "</title>
</head>
<body>
";
        // line 10
        if (isset($context["snippets"])) { $_snippets_ = $context["snippets"]; } else { $_snippets_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_snippets_, "test"), "test", array(), "method"), "html", null, true);
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "pages/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 10,  33 => 7,  27 => 3,  22 => 2,  19 => 1,);
    }
}
