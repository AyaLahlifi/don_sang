<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @zuvi/template-parts/style.html.twig */
class __TwigTemplate_a7a598d2fb44cd798c52815c39e6756d extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<style>
  @media (min-width: 1200px) {
  .container {
    max-width: ";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["container_width"] ?? null), 4, $this->source), "html", null, true);
        echo "px;
  }
}
";
        // line 8
        if ((($context["header_width"] ?? null) == "header_width_full")) {
            // line 9
            echo ".header .container,
.page-header .container {
  width: 100%;
  max-width: 100%;
}
";
        }
        // line 15
        if ((($context["main_width"] ?? null) == "main_width_full")) {
            // line 16
            echo ".main-wrapper .container {
  width: 100%;
  max-width: 100%;
}
";
        }
        // line 21
        echo "
";
        // line 22
        if ((($context["footer_width"] ?? null) == "footer_width_full")) {
            // line 23
            echo ".footer .container {
  width: 100%;
  max-width: 100%;
}
";
        }
        // line 28
        if (($context["highlight_author_comment"] ?? null)) {
            // line 29
            echo ".comment-by-author {
  box-shadow: 0 0 3px var(--color-primary);
}
";
        }
        // line 33
        echo "</style>";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["container_width", "header_width", "main_width", "footer_width", "highlight_author_comment"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@zuvi/template-parts/style.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  89 => 33,  83 => 29,  81 => 28,  74 => 23,  72 => 22,  69 => 21,  62 => 16,  60 => 15,  52 => 9,  50 => 8,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@zuvi/template-parts/style.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\themes\\zuvi\\templates\\template-parts\\style.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 8);
        static $filters = array("escape" => 4);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
