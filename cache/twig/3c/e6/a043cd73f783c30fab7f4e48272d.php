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
        $context['snippets']['test']->init($context['controller']);
        $context['snippets']['test']->execute();
        // line 2
        $context['js'][] = '/test.js';
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
";
        // line 11
        foreach (core\Arr::get($context, 'js', array()) as $src) {
            echo '<script src="'.$src.'"></script>'."\n";        }
        // line 12
        echo "</body>
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
        return array (  46 => 12,  43 => 11,  38 => 10,  31 => 7,  25 => 3,  23 => 2,  19 => 1,);
    }
}
