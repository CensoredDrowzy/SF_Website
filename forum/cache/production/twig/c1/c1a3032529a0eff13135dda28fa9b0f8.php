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

/* feed.xml.twig */
class __TwigTemplate_fd4eae60626fbd426323de29313de2c4 extends \Twig\Template
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
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<feed xmlns=\"http://www.w3.org/2005/Atom\" xml:lang=\"";
        // line 2
        echo ($context["FEED_LANG"] ?? null);
        echo "\">
\t<link rel=\"self\" type=\"application/atom+xml\" href=\"";
        // line 3
        echo ($context["SELF_LINK"] ?? null);
        echo "\" />

\t";
        // line 5
        if ( !twig_test_empty(($context["FEED_TITLE"] ?? null))) {
            echo "<title>";
            echo ($context["FEED_TITLE"] ?? null);
            echo "</title>";
        }
        // line 6
        echo "
\t";
        // line 7
        if ( !twig_test_empty(($context["FEED_SUBTITLE"] ?? null))) {
            echo "<subtitle>";
            echo ($context["FEED_SUBTITLE"] ?? null);
            echo "</subtitle>";
        }
        // line 8
        echo "
\t";
        // line 9
        if ( !twig_test_empty(($context["FEED_LINK"] ?? null))) {
            echo "<link href=\"";
            echo ($context["FEED_LINK"] ?? null);
            echo "\" />";
        }
        // line 10
        echo "
\t<updated>";
        // line 11
        echo ($context["FEED_UPDATED"] ?? null);
        echo "</updated>

\t<author><name><![CDATA[";
        // line 13
        echo ($context["FEED_AUTHOR"] ?? null);
        echo "]]></name></author>
\t<id>";
        // line 14
        echo ($context["SELF_LINK"] ?? null);
        echo "</id>

\t";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["FEED_ROWS"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 17
            echo "\t<entry>
\t\t";
            // line 18
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["row"], "author", [], "any", false, false, false, 18))) {
                echo "<author><name><![CDATA[";
                echo twig_get_attribute($this->env, $this->source, $context["row"], "author", [], "any", false, false, false, 18);
                echo "]]></name></author>";
            }
            // line 19
            echo "
\t\t<updated>";
            // line 20
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["row"], "updated", [], "any", false, false, false, 20))) {
                echo twig_get_attribute($this->env, $this->source, $context["row"], "updated", [], "any", false, false, false, 20);
            } else {
                echo twig_get_attribute($this->env, $this->source, $context["row"], "published", [], "any", false, false, false, 20);
            }
            echo "</updated>

\t\t";
            // line 22
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["row"], "published", [], "any", false, false, false, 22))) {
                echo "<published>";
                echo twig_get_attribute($this->env, $this->source, $context["row"], "published", [], "any", false, false, false, 22);
                echo "</published>";
            }
            // line 23
            echo "
\t\t<id>";
            // line 24
            echo twig_get_attribute($this->env, $this->source, $context["row"], "link", [], "any", false, false, false, 24);
            echo "</id>
\t\t<link href=\"";
            // line 25
            echo twig_get_attribute($this->env, $this->source, $context["row"], "link", [], "any", false, false, false, 25);
            echo "\"/>
\t\t<title type=\"html\"><![CDATA[";
            // line 26
            echo twig_get_attribute($this->env, $this->source, $context["row"], "title", [], "any", false, false, false, 26);
            echo "]]></title>

\t\t";
            // line 28
            if ((( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["row"], "category", [], "any", false, false, false, 28)) && twig_get_attribute($this->env, $this->source, $context["row"], "category_name", [], "any", true, true, false, 28)) && (twig_get_attribute($this->env, $this->source, $context["row"], "category_name", [], "any", false, false, false, 28) != ""))) {
                // line 29
                echo "\t\t\t<category term=\"";
                echo twig_get_attribute($this->env, $this->source, $context["row"], "category_name", [], "any", false, false, false, 29);
                echo "\" scheme=\"";
                echo twig_get_attribute($this->env, $this->source, $context["row"], "category", [], "any", false, false, false, 29);
                echo "\" label=\"";
                echo twig_get_attribute($this->env, $this->source, $context["row"], "category_name", [], "any", false, false, false, 29);
                echo "\"/>
\t\t";
            }
            // line 31
            echo "
\t\t<content type=\"html\" xml:base=\"";
            // line 32
            echo twig_get_attribute($this->env, $this->source, $context["row"], "link", [], "any", false, false, false, 32);
            echo "\"><![CDATA[
";
            // line 33
            echo twig_get_attribute($this->env, $this->source, $context["row"], "description", [], "any", false, false, false, 33);
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["row"], "statistics", [], "any", false, false, false, 33))) {
                echo "<p>";
                echo $this->extensions['phpbb\template\twig\extension']->lang("STATISTICS");
                echo ": ";
                echo twig_get_attribute($this->env, $this->source, $context["row"], "statistics", [], "any", false, false, false, 33);
                echo "</p>";
            }
            echo "<hr />
]]></content>
\t</entry>
\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "</feed>
";
    }

    public function getTemplateName()
    {
        return "feed.xml.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  173 => 37,  156 => 33,  152 => 32,  149 => 31,  139 => 29,  137 => 28,  132 => 26,  128 => 25,  124 => 24,  121 => 23,  115 => 22,  106 => 20,  103 => 19,  97 => 18,  94 => 17,  90 => 16,  85 => 14,  81 => 13,  76 => 11,  73 => 10,  67 => 9,  64 => 8,  58 => 7,  55 => 6,  49 => 5,  44 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "feed.xml.twig", "");
    }
}
