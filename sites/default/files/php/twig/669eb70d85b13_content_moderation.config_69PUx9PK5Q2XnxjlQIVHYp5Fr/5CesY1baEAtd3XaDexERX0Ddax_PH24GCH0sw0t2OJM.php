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

/* @help_topics/content_moderation.configuring_workflows.html.twig */
class __TwigTemplate_ade7e81568a19fb59c4cc2c9a72050f1 extends Template
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
        // line 9
        $context["content_structure_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getTopicLink("core.content_structure"));
        // line 10
        $context["user_overview_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getTopicLink("user.overview"));
        // line 11
        $context["user_permissions_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getTopicLink("user.permissions"));
        // line 12
        $context["workflows_overview_topic"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getTopicLink("workflows.overview"));
        // line 13
        ob_start(function () { return ''; });
        echo t("Content Moderation", array());
        $context["content_moderation_permissions_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 14
        $context["content_moderation_permissions_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["content_moderation_permissions_link_text"] ?? null), 14, $this->source), "user.admin_permissions", [], ["fragment" => "module-content_moderation"]));
        // line 15
        ob_start(function () { return ''; });
        echo t("Administer workflows", array());
        $context["workflows_permissions_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 16
        $context["workflows_permissions_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["workflows_permissions_link_text"] ?? null), 16, $this->source), "user.admin_permissions", [], ["fragment" => "module-workflows"]));
        // line 17
        ob_start(function () { return ''; });
        echo t("Workflows", array());
        $context["workflows_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 18
        $context["workflows_link"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["workflows_link_text"] ?? null), 18, $this->source), "entity.workflow.collection"));
        // line 19
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 20
        echo t("Create or edit a workflow with various workflow states (for example <em>Concept</em>, <em>Archived</em>, etc.) for moderating content. See @workflows_overview_topic for more information on workflows.", array("@workflows_overview_topic" => ($context["workflows_overview_topic"] ?? null), ));
        echo "</p>
<h2>";
        // line 21
        echo t("Who can configure a workflow?", array());
        echo "</h2>
<p>";
        // line 22
        echo t("Users with <em>workflows permissions</em> (typically administrators) can configure workflows. See Permissions &gt; <em>@workflows_permissions_link</em> to configure workflows permissions.", array("@workflows_permissions_link" => ($context["workflows_permissions_link"] ?? null), ));
        echo "</p>
<h2>";
        // line 23
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 25
        echo t("Make a plan for the new workflow:", array());
        // line 26
        echo "    <ul>
      <li>";
        // line 27
        echo t("Decide which workflow states you need; for example, <em>Concept</em>, <em>Review</em>, and <em>Final</em>.", array());
        echo "</li>
      <li>";
        // line 28
        echo t("Decide on the settings for each state:", array());
        // line 29
        echo "        <ul>
          <li>";
        // line 30
        echo t("<em>Label</em>: the state name", array());
        echo "</li>
          <li>";
        // line 31
        echo t("<em>Published</em>: if checked, when content reaches this state it will be made visible on the site (to users with permission).", array());
        echo "</li>
          <li>";
        // line 32
        echo t("<em>Default revision</em>: if checked, when content reaches this state it will become the default revision of the content; published content is automatically the default revision.", array());
        echo "</li>
        </ul>
      </li>
      <li>";
        // line 35
        echo t("Decide which state content should be created in.", array());
        echo "</li>
      <li>";
        // line 36
        echo t("Decide on the list of allowed transitions between states. For example, you might want a transition between <em>Concept</em> and <em>Review</em>. Each transition has a label; for example, the Concept to Review transition might be labeled \"Review concept\".", array());
        echo "</li>
      <li>";
        // line 37
        echo t("Decide which roles should have permissions to make each transition; see @user_overview_topic for an overview of roles and permissions.", array("@user_overview_topic" => ($context["user_overview_topic"] ?? null), ));
        echo "</li>
      <li>";
        // line 38
        echo t("Decide which <em>entity types</em> and subtypes the workflow should apply to. Only entity types that support revisions are possible to define workflows for. See @content_structure_topic for more information on content entities and fields.", array("@content_structure_topic" => ($context["content_structure_topic"] ?? null), ));
        echo "</li>
    </ul>
  </li>
  <li>";
        // line 41
        echo t("To implement your plan, in the <em>Manage</em> administrative menu, navigate to <em>Configuration</em> &gt; <em>Workflow</em> &gt; <em>@workflows_link</em>. A list of workflows is shown, including the default workflow <em>Editorial</em> that you can adapt.", array("@workflows_link" => ($context["workflows_link"] ?? null), ));
        echo "</li>
  <li>";
        // line 42
        echo t("Click <em>Add workflow</em>.", array());
        echo "</li>
  <li>";
        // line 43
        echo t("Enter a name in the <em>Label</em> field, select <em>Content moderation</em> from the <em>Workflow type</em> field, and click <em>Save</em>.", array());
        echo "</li>
  <li>";
        // line 44
        echo t("Verify that the <em>States</em> list matches your planned states. You can add missing states by clicking <em>Add a new state</em>. You can edit or delete states by clicking <em>Edit</em> or <em>Delete</em> under <em>Operations</em> (if the <em>Delete</em> option is not available, you will first need to delete any <em>Transitions</em> to or from this state).", array());
        echo "</li>
  <li>";
        // line 45
        echo t("Verify that the <em>Transitions</em> list matches your plan. You can add missing transitions by clicking <em>Add a new transition</em>. You can edit or delete transitions by clicking <em>Edit</em> or <em>Delete</em> under <em>Operations</em>.", array());
        echo "</li>
  <li>";
        // line 46
        echo t("Under <em>This workflow applies to:</em>, find the entity type that you want this workflow to apply to, such as Content revisions, Content block revisions, or Taxonomy term revisions. Click <em>Select</em>.", array());
        echo "</li>
  <li>";
        // line 47
        echo t("Check the entity subtypes that you want to apply the workflow to. For example, you might choose to apply your workflow to the <em>Page</em> content type, but not to <em>Article</em>.", array());
        echo "</li>
  <li>";
        // line 48
        echo t("Click <em>Save</em>.", array());
        echo "</li>
  <li>";
        // line 49
        echo t("Under <em>Workflow settings</em>, select the <em>Default moderation state</em> for new content.", array());
        echo "</li>
  <li>";
        // line 50
        echo t("Click <em>Save</em> to save your workflow.", array());
        echo "</li>
  <li>";
        // line 51
        echo t("Follow the steps in @user_permissions_topic to assign permissions for each transition to roles. The permissions are listed under the <em>@content_moderation_permissions_link</em> section; there is one permission for each transition in each workflow.", array("@user_permissions_topic" => ($context["user_permissions_topic"] ?? null), "@content_moderation_permissions_link" => ($context["content_moderation_permissions_link"] ?? null), ));
        echo "</li>
  <li>";
        // line 52
        echo t("Optionally (recommended), create a view for your custom workflow, to provide a page for content editors to see what content needs to be moderated. You can do this if the Views UI module is installed, by following the steps in the related <em>Creating a new view</em> topic listed below under <em>Related topics</em>. When creating the view, under <em>View settings</em> &gt; <em>Show</em>, select the revision data type you configured the workflow for, and be sure to display the <em>Workflow State</em> field in your view.", array());
        echo "</li>
</ol>";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@help_topics/content_moderation.configuring_workflows.html.twig";
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
        return array (  177 => 52,  173 => 51,  169 => 50,  165 => 49,  161 => 48,  157 => 47,  153 => 46,  149 => 45,  145 => 44,  141 => 43,  137 => 42,  133 => 41,  127 => 38,  123 => 37,  119 => 36,  115 => 35,  109 => 32,  105 => 31,  101 => 30,  98 => 29,  96 => 28,  92 => 27,  89 => 26,  87 => 25,  82 => 23,  78 => 22,  74 => 21,  70 => 20,  65 => 19,  63 => 18,  59 => 17,  57 => 16,  53 => 15,  51 => 14,  47 => 13,  45 => 12,  43 => 11,  41 => 10,  39 => 9,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/content_moderation.configuring_workflows.html.twig", "C:\\xampp\\htdocs\\Drupalwebb\\core\\modules\\content_moderation\\help_topics\\content_moderation.configuring_workflows.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 9, "trans" => 13);
        static $filters = array("escape" => 20);
        static $functions = array("render_var" => 9, "help_topic_link" => 9, "help_route_link" => 14);

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
