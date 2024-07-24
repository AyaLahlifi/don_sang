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

/* themes/zuvi/templates/views/views-view.html.twig */
class __TwigTemplate_06d0ceb217aa53245a3b9a15de137701 extends Template
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
        // line 34
        $context["classes"] = ["view", ("view-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(        // line 36
($context["id"] ?? null), 36, $this->source))), ("view-id-" . $this->sandbox->ensureToStringAllowed(        // line 37
($context["id"] ?? null), 37, $this->source)), ("view-display-id-" . $this->sandbox->ensureToStringAllowed(        // line 38
($context["display_id"] ?? null), 38, $this->source)), ((        // line 39
($context["dom_id"] ?? null)) ? (("js-view-dom-id-" . $this->sandbox->ensureToStringAllowed(($context["dom_id"] ?? null), 39, $this->source))) : (""))];
        // line 42
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 42), 42, $this->source), "html", null, true);
        echo ">
  ";
        // line 43
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null), 43, $this->source), "html", null, true);
        echo "
  ";
        // line 44
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 44, $this->source), "html", null, true);
        echo "
  ";
        // line 45
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null), 45, $this->source), "html", null, true);
        echo "

  ";
        // line 47
        if (($context["header"] ?? null)) {
            // line 48
            echo "    <div class=\"view-header\">
      ";
            // line 49
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["header"] ?? null), 49, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 52
        echo "
  ";
        // line 53
        if (($context["exposed"] ?? null)) {
            // line 54
            echo "    <div class=\"view-filters\">
      ";
            // line 55
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["exposed"] ?? null), 55, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 58
        echo "  ";
        if (($context["attachment_before"] ?? null)) {
            // line 59
            echo "    <div class=\"attachment view-attachment attachment-before\">
      ";
            // line 60
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attachment_before"] ?? null), 60, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 63
        echo "
  ";
        // line 64
        if (($context["rows"] ?? null)) {
            // line 65
            echo "    <div class=\"view-content\">
      ";
            // line 66
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["rows"] ?? null), 66, $this->source), "html", null, true);
            echo "
    </div>
  ";
        } elseif (        // line 68
($context["empty"] ?? null)) {
            // line 69
            echo "    <div class=\"view-empty\">
      ";
            // line 70
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["empty"] ?? null), 70, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 73
        echo "
  ";
        // line 74
        if (($context["pager"] ?? null)) {
            // line 75
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["pager"] ?? null), 75, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 77
        echo "
  ";
        // line 78
        if (($context["attachment_after"] ?? null)) {
            // line 79
            echo "    <div class=\"attachment view-attachment attachment-after\">
      ";
            // line 80
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attachment_after"] ?? null), 80, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 83
        echo "  ";
        if (($context["more"] ?? null)) {
            // line 84
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["more"] ?? null), 84, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 86
        echo "
  ";
        // line 87
        if (($context["footer"] ?? null)) {
            // line 88
            echo "    <div class=\"view-footer\">
      ";
            // line 89
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["footer"] ?? null), 89, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 92
        echo "
  ";
        // line 93
        if (($context["feed_icons"] ?? null)) {
            // line 94
            echo "    <div class=\"feed-icons view-feed-icons\">
      ";
            // line 95
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["feed_icons"] ?? null), 95, $this->source), "html", null, true);
            echo "
    </div>
  ";
        }
        // line 98
        echo "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["id", "display_id", "dom_id", "attributes", "title_prefix", "title", "title_suffix", "header", "exposed", "attachment_before", "rows", "empty", "pager", "attachment_after", "more", "footer", "feed_icons"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "themes/zuvi/templates/views/views-view.html.twig";
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
        return array (  186 => 98,  180 => 95,  177 => 94,  175 => 93,  172 => 92,  166 => 89,  163 => 88,  161 => 87,  158 => 86,  152 => 84,  149 => 83,  143 => 80,  140 => 79,  138 => 78,  135 => 77,  129 => 75,  127 => 74,  124 => 73,  118 => 70,  115 => 69,  113 => 68,  108 => 66,  105 => 65,  103 => 64,  100 => 63,  94 => 60,  91 => 59,  88 => 58,  82 => 55,  79 => 54,  77 => 53,  74 => 52,  68 => 49,  65 => 48,  63 => 47,  58 => 45,  54 => 44,  50 => 43,  45 => 42,  43 => 39,  42 => 38,  41 => 37,  40 => 36,  39 => 34,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/zuvi/templates/views/views-view.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\themes\\zuvi\\templates\\views\\views-view.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 34, "if" => 47);
        static $filters = array("clean_class" => 36, "escape" => 42);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['clean_class', 'escape'],
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
