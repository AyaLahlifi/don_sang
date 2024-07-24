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

/* @help_topics/content_moderation.changing_states.html.twig */
class __TwigTemplate_2a3880c67de418937f3670167ddf009d extends Template
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
        // line 8
        $context["workflows_overview_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getTopicLink("workflows.overview"));
        // line 9
        $context["content_structure_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getTopicLink("core.content_structure"));
        // line 10
        ob_start(function () { return ''; });
        echo t("Content Moderation", array());
        $context["content_moderation_permissions_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 11
        $context["content_moderation_permissions_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["content_moderation_permissions_link_text"] ?? null), 11, $this->source), "user.admin_permissions", [], ["fragment" => "module-content_moderation"]));
        // line 12
        ob_start(function () { return ''; });
        echo t("Content", array());
        $context["content_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 13
        $context["content_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["content_link_text"] ?? null), 13, $this->source), "system.admin_content"));
        // line 14
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 15
        echo t("Change the workflow state of a particular entity. See @workflows_overview_topic for an overview of workflows, and @content_structure_topic for an overview of content entities.", array("@workflows_overview_topic" => ($context["workflows_overview_topic"] ?? null), "@content_structure_topic" => ($context["content_structure_topic"] ?? null), ));
        echo "</p>
<h2>";
        // line 16
        echo t("Who can change workflow states?", array());
        echo "</h2>
<p>";
        // line 17
        echo t("Users with <em>content moderation permissions</em> can change workflow states. There are separate permissions for each transition. See Permissions &gt; <em>@content_moderation_permissions_link</em> to configure content moderation permissions.", array("@content_moderation_permissions_link" => ($context["content_moderation_permissions_link"] ?? null), ));
        echo "</p>
<h2>";
        // line 18
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 20
        echo t("Find the entity that you want to moderate in either the content moderation view page, if you created one, or the appropriate administrative page for managing that type of entity (such as the administration page for content items; see @content_link).", array("@content_link" => ($context["content_link"] ?? null), ));
        echo "</li>
  <li>";
        // line 21
        echo t("Click <em>Edit</em> to edit the entity.", array());
        echo "</li>
  <li>";
        // line 22
        echo t("At the bottom of the page, select the new workflow state under <em>Change to:</em> and click <em>Save</em>.", array());
        echo "</li>
</ol>";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@help_topics/content_moderation.changing_states.html.twig";
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
        return array (  85 => 22,  81 => 21,  77 => 20,  72 => 18,  68 => 17,  64 => 16,  60 => 15,  55 => 14,  53 => 13,  49 => 12,  47 => 11,  43 => 10,  41 => 9,  39 => 8,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/content_moderation.changing_states.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\core\\modules\\content_moderation\\help_topics\\content_moderation.changing_states.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 8, "trans" => 10);
        static $filters = array("escape" => 15);
        static $functions = array("render_var" => 8, "help_topic_link" => 8, "help_route_link" => 11);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'help_topic_link', 'help_route_link']
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
