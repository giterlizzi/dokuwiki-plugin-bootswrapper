<?php
/**
 * Bootstrap Wrapper Plugin: Well
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_well extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'normal';
    public $pattern_start  = '<well.*?>(?=.*?</well>)';
    public $pattern_end    = '</well>';
    public $tag_name       = 'well';
    public $tag_attributes = array(

        'size' => array(
            'type'     => 'string',
            'values'   => array('lg', 'sm'),
            'required' => false,
            'default'  => null),

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
            $size   = ($attributes['size']) ? 'well-' . $attributes['size'] : '';
            $markup = '<div class="bs-wrap bs-wrap-well well ' . $size . '">';

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
