<?php
/**
 * Bootstrap Wrapper Plugin: Image
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_image extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<image.*?>(?=.*?</image>)';
    public $pattern_end    = '</image>';
    public $tag_name       = 'image';
    public $tag_attributes = array(
        'shape' => array(
            'type'     => 'string',
            'values'   => array('rounded', 'circle', 'thumbnail', 'responsive'),
            'required' => false,
            'default'  => ''),
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
            extract($attributes);

            $html5_data = array();

            if ($shape) {
                $html5_data[] = 'data-img-shape="' . $shape . '"';
            }

            $markup = '<span class="bs-wrap bs-wrap-image" ' . implode(' ', $html5_data) . '>';

            $renderer->doc .= $markup;
            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= '</span>';
            return true;
        }

        return true;
    }
}
