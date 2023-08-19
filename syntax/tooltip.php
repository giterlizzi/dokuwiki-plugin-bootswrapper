<?php
/**
 * Bootstrap Wrapper Plugin: Tooltip
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_tooltip extends syntax_plugin_bootswrapper_bootstrap
{
    public $p_type         = 'normal';
    public $pattern_start  = '<tooltip.*?>(?=.*?</tooltip>)';
    public $pattern_end    = '</tooltip>';
    public $tag_name       = 'tooltip';
    public $tag_attributes = array(

        'placement' => array(
            'type'     => 'string',
            'values'   => array('top', 'bottom', 'left', 'right', 'auto'),
            'required' => true,
            'default'  => 'top'),

        'title'     => array(
            'type'     => 'string',
            'values'   => null,
            'required' => true,
            'default'  => null),

        'html'      => array(
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
        $data = array_pad($data, 4, null);
        list($state, $match, $pos, $attributes) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            $placement = $attributes['placement'] ?? '';
            $title = $attributes['title'] ?? '';
            $html = $attributes['html'] ?? '';

            if (isset($html)) {
                $title = hsc(p_render('xhtml', p_get_instructions($title), $info));
            }

            $markup = '<span class="bs-wrap bs-wrap-tooltip" data-toggle="tooltip" data-html="' . $html . '" data-placement="' . $placement . '" title="' . $title . '" style="border-bottom:1px dotted">';

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
