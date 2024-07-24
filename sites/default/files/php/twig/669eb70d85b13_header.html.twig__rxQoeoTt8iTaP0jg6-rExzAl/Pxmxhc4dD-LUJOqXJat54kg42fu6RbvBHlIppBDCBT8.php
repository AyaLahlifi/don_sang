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

/* @zuvi/template-parts/header.html.twig */
class __TwigTemplate_d62824c99ba2b50824d6d19ee6a6c31d extends Template
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
        echo "<header class=\"header\">
  <div class=\"container\">
    <div class=\"header-main\">
    ";
        // line 4
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "site_branding", [], "any", false, false, true, 4)) {
            // line 5
            echo "      <div class=\"site-brand\">
        ";
            // line 6
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "site_branding", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
            echo "
      </div> <!--/.site-branding -->
    ";
        }
        // line 9
        echo "    ";
        if ((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 9) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "search_box", [], "any", false, false, true, 9))) {
            // line 10
            echo "      <div class=\"header-main-right\">
        ";
            // line 11
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 11)) {
                // line 12
                echo "          <div class=\"mobile-menu\" aria-label=\"Main Menu\">
            <div class=\"menu-bar\">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>";
                // line 19
                echo "          <div class=\"primary-menu-wrapper\">
            <div class=\"menu-wrap\">
              <div class=\"close-mobile-menu\" aria-label=\"Close Main Menu\"><i class=\"icon-close\"></i></div>
              ";
                // line 22
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 22), 22, $this->source), "html", null, true);
                echo "
            </div><!-- /.menu-wrap -->
          </div><!-- /.primary-menu-wrapper -->
        ";
            }
            // line 26
            echo "        ";
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "search_box", [], "any", false, false, true, 26)) {
                // line 27
                echo "          ";
                $this->loadTemplate("@zuvi/template-parts/search.html.twig", "@zuvi/template-parts/header.html.twig", 27)->display($context);
                // line 28
                echo "        ";
            }
            // line 29
            echo "      </div> <!-- /.header-right -->
    ";
        }
        // line 31
        echo "    </div> <!-- /.header-main -->
  </div> <!-- /.container -->
  ";
        // line 33
        if ( !($context["is_front"] ?? null)) {
            // line 34
            echo "    ";
            $this->loadTemplate("@zuvi/template-parts/page_header.html.twig", "@zuvi/template-parts/header.html.twig", 34)->display($context);
            // line 35
            echo "  ";
        }
        // line 36
        echo "  ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "slider", [], "any", false, false, true, 36)) {
            // line 37
            echo "    ";
            $this->loadTemplate("@zuvi/template-parts/slider.html.twig", "@zuvi/template-parts/header.html.twig", 37)->display($context);
            // line 38
            echo "  ";
        }
        // line 39
        echo "</header>
";
        // line 40
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "slider", [], "any", false, false, true, 40)) {
            // line 41
            echo "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1440 160\"><path fill=\"#020312\" fill-opacity=\"1\" d=\"M0,32L60,26.7C120,21,240,11,360,42.7C480,75,600,149,720,154.7C840,160,960,96,1080,74.7C1200,53,1320,75,1380,85.3L1440,96L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z\"></path></svg>
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "is_front"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@zuvi/template-parts/header.html.twig";
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
        return array (  122 => 41,  120 => 40,  117 => 39,  114 => 38,  111 => 37,  108 => 36,  105 => 35,  102 => 34,  100 => 33,  96 => 31,  92 => 29,  89 => 28,  86 => 27,  83 => 26,  76 => 22,  71 => 19,  63 => 12,  61 => 11,  58 => 10,  55 => 9,  49 => 6,  46 => 5,  44 => 4,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@zuvi/template-parts/header.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\themes\\zuvi\\templates\\template-parts\\header.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 4, "include" => 27);
        static $filters = array("escape" => 6);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'include'],
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
