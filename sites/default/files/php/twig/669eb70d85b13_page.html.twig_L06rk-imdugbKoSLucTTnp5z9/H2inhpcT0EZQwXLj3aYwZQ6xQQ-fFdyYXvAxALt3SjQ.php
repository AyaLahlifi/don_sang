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

/* themes/zuvi/templates/layout/page.html.twig */
class __TwigTemplate_9b24e582d823414d56dac17c71d04e66 extends Template
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
        // line 52
        $this->loadTemplate("@zuvi/template-parts/header.html.twig", "themes/zuvi/templates/layout/page.html.twig", 52)->display($context);
        // line 53
        $this->loadTemplate("@zuvi/template-parts/highlighted.html.twig", "themes/zuvi/templates/layout/page.html.twig", 53)->display($context);
        // line 54
        echo "<div id=\"main-wrapper\" class=\"main-wrapper\">
  <div class=\"container\">
  <div class=\"main-container\">
    <main id=\"main\" class=\"full-width page-content\">
      <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 59
        echo "      ";
        $this->loadTemplate("@zuvi/template-parts/content_top.html.twig", "themes/zuvi/templates/layout/page.html.twig", 59)->display($context);
        // line 60
        echo "      ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
        echo "
      ";
        // line 61
        $this->loadTemplate("@zuvi/template-parts/content_bottom.html.twig", "themes/zuvi/templates/layout/page.html.twig", 61)->display($context);
        // line 62
        echo "    </main>
    ";
        // line 63
        $this->loadTemplate("@zuvi/template-parts/sidebar_left.html.twig", "themes/zuvi/templates/layout/page.html.twig", 63)->display($context);
        // line 64
        echo "    ";
        $this->loadTemplate("@zuvi/template-parts/sidebar_right.html.twig", "themes/zuvi/templates/layout/page.html.twig", 64)->display($context);
        // line 65
        echo "  </div>";
        // line 66
        echo "  </div>";
        // line 67
        echo "</div>";
        // line 68
        $this->loadTemplate("@zuvi/template-parts/footer.html.twig", "themes/zuvi/templates/layout/page.html.twig", 68)->display($context);
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/zuvi/templates/layout/page.html.twig";
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
        return array (  73 => 68,  71 => 67,  69 => 66,  67 => 65,  64 => 64,  62 => 63,  59 => 62,  57 => 61,  52 => 60,  49 => 59,  43 => 54,  41 => 53,  39 => 52,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/zuvi/templates/layout/page.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\themes\\zuvi\\templates\\layout\\page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("include" => 52);
        static $filters = array("escape" => 60);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['include'],
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
