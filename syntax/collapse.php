<?php
/**
 * Bootstrap Wrapper Plugin: Collapse
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_collapse extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<collapse.*?>(?=.*?</collapse>)';
    public $pattern_end    = '</collapse>';
    public $tag_name       = 'collapse';
    public $tag_attributes = array(

        'id'        => array(
            'type'     => 'string',
            'values'   => null,
            'required' => true,
            'default'  => null),

        'collapsed' => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

    );

    public function render($mode, Doku_Renderer $renderer, $data)
    {

        if (empty($data)) {
            return false;
        }

        if ($mode !== 'xhtml') {
            return false;
        }

        /** @var Doku_Renderer_xhtml $renderer */
        list($state, $match, $pos, $attributes) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            $id        = $attributes['id'];
            $collapsed = $attributes['collapsed'];
            $markup    = '<div class="bs-wrap bs-wrap-collapse collapse ' . ($collapsed ? '' : 'in') . '" id="' . $id . '">';

            $renderer->doc .= $markup;
            return true;

        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= '</div>';
            return true;
        }

        return true;
    }
}
