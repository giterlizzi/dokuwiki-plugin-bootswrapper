<?php
/**
 * Bootstrap Wrapper Plugin: Column
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_column extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<col\b.*?>(?=.*?</col>)';
    public $pattern_end    = '</col>';
    public $tag_name       = 'col';
    public $tag_attributes = array(

        'lg' => array(
            'type'     => 'integer',
            'values'   => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'min'      => 1,
            'max'      => 12,
            'required' => false,
            'default'  => null),

        'md' => array(
            'type'     => 'integer',
            'values'   => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'min'      => 1,
            'max'      => 12,
            'required' => false,
            'default'  => null),

        'sm' => array(
            'type'     => 'integer',
            'values'   => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'min'      => 1,
            'max'      => 12,
            'required' => false,
            'default'  => null),

        'xs' => array(
            'type'     => 'integer',
            'values'   => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'min'      => 1,
            'max'      => 12,
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
            $col = '';

            foreach (array('lg', 'md', 'sm', 'xs') as $device) {
                $col .= isset($attributes[$device]) ? "col-$device-{$attributes[$device]} " : '';
            }

            $markup = '<div class="bs-wrap bs-wrap-col ' . trim($col) . '">';

            $renderer->doc .= $markup;
            return true;
        }

        if ($state == DOKU_LEXER_UNMATCHED) {
            $renderer->doc .= $match;
            return true;

        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= "</div>";
            return true;
        }

        return true;
    }
}
