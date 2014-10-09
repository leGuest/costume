<?php

/* CostumeList.twig */
class __TwigTemplate_f07ee49569c8d29d9bd4507dd01130a5945b16a30f9fdf98e6e72b560684643d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if ((isset($context["costumes"]) ? $context["costumes"] : null)) {
            // line 2
            echo "  <table>
    <th>name</th>
    <th>preview</th>
    <th>values</th>
  ";
            // line 6
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["costumes"]) ? $context["costumes"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["costume"]) {
                // line 7
                echo "    <tr>
      <td>";
                // line 8
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["costume"]) ? $context["costume"] : null), "name"), "html", null, true);
                echo "</td>
      <td>
      ";
                // line 10
                if (twig_test_empty(trim($this->getAttribute((isset($context["costume"]) ? $context["costume"] : null), "image"), ""))) {
                    // line 11
                    echo "        no image
      ";
                } else {
                    // line 13
                    echo "        ";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["costume"]) ? $context["costume"] : null), "image"), "html", null, true);
                    echo "
      ";
                }
                // line 15
                echo "      </td>
      <td>";
                // line 16
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["costume"]) ? $context["costume"] : null), "tokens"), "html", null, true);
                echo "</td>
    </tr>
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['costume'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo "  </table>
";
        } else {
            // line 21
            echo "  <div>No costumes to show</div>
";
        }
        // line 23
        echo "
<a href=\"/costume/add\">add costume</a>
";
    }

    public function getTemplateName()
    {
        return "CostumeList.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 23,  67 => 21,  63 => 19,  54 => 16,  51 => 15,  45 => 13,  41 => 11,  39 => 10,  34 => 8,  31 => 7,  27 => 6,  21 => 2,  19 => 1,);
    }
}
