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

/* @zuvi/template-parts/slider.html.twig */
class __TwigTemplate_17352168b880abe30c2d11103d6aa923 extends Template
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
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("zuvi/slider"), "html", null, true);
        echo "
<section class=\"slider\">
  <div class=\"container\">
  <div class=\"slider-container\">
    <div class=\"slider-text\">
      ";
        // line 6
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "slider", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
        echo "
    </div><!-- /slider-text -->
    <div class=\"slider-image\">
      ";
        // line 9
        if ((($context["slider_image_path"] ?? null) != "")) {
            // line 10
            echo "        <img src=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["slider_image_path"] ?? null), 10, $this->source), "html", null, true);
            echo "\" alt=\"slider image\" />
      ";
        } else {
            // line 12
            echo "        <img src=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 12, $this->source) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 12, $this->source)), "html", null, true);
            echo "/images/demo-images/slider.svg\" alt=\"slider image\" />
      ";
        }
        // line 14
        echo "    </div><!-- /slider-image -->
  </div> <!--/.slider-container -->
  </div> <!--/.container -->
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "slider_image_path", "base_path", "directory"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@zuvi/template-parts/slider.html.twig";
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
        return array (  67 => 14,  61 => 12,  55 => 10,  53 => 9,  47 => 6,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@zuvi/template-parts/slider.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\themes\\zuvi\\templates\\template-parts\\slider.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 9);
        static $filters = array("escape" => 1);
        static $functions = array("attach_library" => 1);

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                ['attach_library']
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
