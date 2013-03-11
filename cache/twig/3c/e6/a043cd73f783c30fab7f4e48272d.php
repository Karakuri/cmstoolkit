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
        core\Snippet::get('test')->_init('test', $context['controller']);
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
        if (isset($context["snippet"])) { $_snippet_ = $context["snippet"]; } else { $_snippet_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($_snippet_, "test"), "test", array(), "method"), "html", null, true);
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
        return array (  39 => 10,  32 => 7,  26 => 3,  21 => 2,  19 => 1,);
    }
}
