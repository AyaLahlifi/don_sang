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

/* @zuvi/template-parts/footer.html.twig */
class __TwigTemplate_b90272933f9d1a25855f5bac44c38359 extends Template
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
        echo "<footer class=\"footer full-width\">
  ";
        // line 2
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_top", [], "any", false, false, true, 2)) {
            // line 3
            echo "    <section class=\"footer-top-section full-width\">
      <div class=\"container\">
        <div class=\"footer-top\">
          ";
            // line 6
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_top", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
            echo "
        </div>
      </div>
    </section>
  ";
        }
        // line 10
        echo "<!-- /footer-top -->
  ";
        // line 11
        if ((((twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 11) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 11)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 11)) || twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 11))) {
            // line 12
            echo "    <section class=\"footer-blocks-section full-width\">
      <div class=\"container\">
      <div class=\"footer-container\">        
        ";
            // line 15
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 15)) {
                // line 16
                echo "          <div class=\"footer-block\">
            ";
                // line 17
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 17), 17, $this->source), "html", null, true);
                echo "
          </div>
        ";
            }
            // line 20
            echo "        ";
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 20)) {
                // line 21
                echo "          <div class=\"footer-block\">          
            ";
                // line 22
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 22), 22, $this->source), "html", null, true);
                echo "          
          </div>
        ";
            }
            // line 25
            echo "        ";
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 25)) {
                // line 26
                echo "          <div class=\"footer-block\">          
            ";
                // line 27
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 27), 27, $this->source), "html", null, true);
                echo "          
          </div>
        ";
            }
            // line 30
            echo "        ";
            if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 30)) {
                // line 31
                echo "          <div class=\"footer-block\">          
            ";
                // line 32
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 32), 32, $this->source), "html", null, true);
                echo "          
          </div>
        ";
            }
            // line 35
            echo "      </div><!--/footer-container -->
      </div><!--/container -->
    </section> <!--/footer-blocks -->
  ";
        }
        // line 38
        echo " ";
        // line 39
        echo "  ";
        if (twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 39)) {
            // line 40
            echo "    <section class=\"footer-bottom-section full-width\">
      <div class=\"container\">
        <div class=\"footer-bottom\">
          ";
            // line 43
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 43), 43, $this->source), "html", null, true);
            echo "
        </div>
      </div>
    </section>
  ";
        }
        // line 47
        echo "<!-- /footer-bottom -->
 ";
        // line 48
        if ((($context["copyright_text"] ?? null) || ($context["all_icons_show"] ?? null))) {
            // line 49
            echo "  <section class=\"footer-bottom-last-section full-width\">
    <div class=\"container\">
    <div class=\"footer-bottom-last\">
      ";
            // line 52
            if (($context["copyright_text"] ?? null)) {
                // line 53
                echo "          <div class=\"copyright\">
            &copy; ";
                // line 54
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
                echo " ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_name"] ?? null), 54, $this->source), "html", null, true);
                echo ", All rights reserved.
          </div>
      ";
            }
            // line 57
            echo "      ";
            if (($context["all_icons_show"] ?? null)) {
                // line 58
                echo "        ";
                $this->loadTemplate("@zuvi/template-parts/social-icons.html.twig", "@zuvi/template-parts/footer.html.twig", 58)->display($context);
                // line 59
                echo "      ";
            }
            // line 60
            echo "      </div>
    </div>
    </div>
  </section>
  ";
        }
        // line 65
        echo "</footer>
";
        // line 66
        if (($context["scrolltotop_on"] ?? null)) {
            // line 67
            echo "  <div class=\"scrolltop\">
    <div class=\"scrolltop-icon\"><i class=\"icon-arrow-up\"></i></div>
  </div>
";
        }
        // line 71
        $this->loadTemplate("@zuvi/template-parts/style.html.twig", "@zuvi/template-parts/footer.html.twig", 71)->display($context);
        // line 72
        if (($context["fontawesome_four"] ?? null)) {
            // line 73
            echo "  ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("zuvi/fontawesome4"), "html", null, true);
            echo "
";
        }
        // line 75
        if (($context["fontawesome_five"] ?? null)) {
            // line 76
            echo "  ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("zuvi/fontawesome5"), "html", null, true);
            echo "
";
        }
        // line 78
        if (($context["bootstrapicons"] ?? null)) {
            // line 79
            echo "  ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("zuvi/bootstrap-icons"), "html", null, true);
            echo "
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "copyright_text", "all_icons_show", "site_name", "scrolltotop_on", "fontawesome_four", "fontawesome_five", "bootstrapicons"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@zuvi/template-parts/footer.html.twig";
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
        return array (  208 => 79,  206 => 78,  200 => 76,  198 => 75,  192 => 73,  190 => 72,  188 => 71,  182 => 67,  180 => 66,  177 => 65,  170 => 60,  167 => 59,  164 => 58,  161 => 57,  153 => 54,  150 => 53,  148 => 52,  143 => 49,  141 => 48,  138 => 47,  130 => 43,  125 => 40,  122 => 39,  120 => 38,  114 => 35,  108 => 32,  105 => 31,  102 => 30,  96 => 27,  93 => 26,  90 => 25,  84 => 22,  81 => 21,  78 => 20,  72 => 17,  69 => 16,  67 => 15,  62 => 12,  60 => 11,  57 => 10,  49 => 6,  44 => 3,  42 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@zuvi/template-parts/footer.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\themes\\zuvi\\templates\\template-parts\\footer.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 2, "include" => 58);
        static $filters = array("escape" => 6, "date" => 54);
        static $functions = array("attach_library" => 73);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'include'],
                ['escape', 'date'],
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
