<?php
/**
 * Bootstrap Wrapper Plugin: Jumbotron
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_jumbotron extends syntax_plugin_bootswrapper_bootstrap
{

    public $pattern_start  = '<(?:JUMBOTRON|jumbotron).*?>(?=.*?</(?:JUMBOTRON|jumbotron)>)';
    public $pattern_end    = '</(?:JUMBOTRON|jumbotron)>';
    public $tag_name       = 'jumbotron';
    public $tag_attributes = array(

        'background' => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'color'      => array(
            'type'     => 'string',
            'values'   => null,
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
        list($state, $match, $pos, $attributes, $is_block) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            $background = $attributes['background'];
            $color      = $attributes['color'];

            $styles = array();

            if ($background) {
                $styles[] = 'background-image:url(' . ml($background) . ')';
            }

            if ($color) {
                $styles[] = 'color:' . hsc($color);
            }

            $markup = '<div class="bs-wrap bs-wrap-jumbotron jumbotron" style="' . implode(';', $styles) . '">';

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
