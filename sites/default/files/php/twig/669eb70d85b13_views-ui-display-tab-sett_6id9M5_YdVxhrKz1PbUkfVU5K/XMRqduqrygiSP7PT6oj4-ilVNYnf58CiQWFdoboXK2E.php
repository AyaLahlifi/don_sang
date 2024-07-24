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

/* core/themes/stable9/templates/admin/views-ui-display-tab-setting.html.twig */
class __TwigTemplate_29bbe58bd5361c9857546b0d80d3d5a2 extends Template
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
        // line 20
        $context["classes"] = ["views-display-setting", "clearfix", "views-ui-display-tab-setting", ((        // line 24
($context["defaulted"] ?? null)) ? ("defaulted") : ("")), ((        // line 25
($context["overridden"] ?? null)) ? ("overridden") : (""))];
        // line 28
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 28), 28, $this->source), "html", null, true);
        echo ">
  ";
        // line 29
        if (($context["description"] ?? null)) {
            // line 30
            echo "<span class=\"label\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["description"] ?? null), 30, $this->source), "html", null, true);
            echo "</span>";
        }
        // line 32
        echo "  ";
        if (($context["settings_links"] ?? null)) {
            // line 33
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, $this->sandbox->ensureToStringAllowed(($context["settings_links"] ?? null), 33, $this->source), "<span class=\"label\">&nbsp;|&nbsp;</span>"));
            echo "
  ";
        }
        // line 35
        echo "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["defaulted", "overridden", "attributes", "description", "settings_links"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "core/themes/stable9/templates/admin/views-ui-display-tab-setting.html.twig";
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
        return array (  64 => 35,  58 => 33,  55 => 32,  50 => 30,  48 => 29,  43 => 28,  41 => 25,  40 => 24,  39 => 20,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/stable9/templates/admin/views-ui-display-tab-setting.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\core\\themes\\stable9\\templates\\admin\\views-ui-display-tab-setting.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 20, "if" => 29);
        static $filters = array("escape" => 28, "safe_join" => 33);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape', 'safe_join'],
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
