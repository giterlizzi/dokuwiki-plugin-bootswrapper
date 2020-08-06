<?php
/**
 * Bootstrap Wrapper Plugin: Label
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_label extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'normal';
    public $pattern_start  = '<(?:LABEL|label).*?>(?=.*?</(?:LABEL|label)>)';
    public $pattern_end    = '</(?:LABEL|label)>';
    public $tag_name       = 'label';
    public $tag_attributes = array(

        'type' => array(
            'type'     => 'string',
            'values'   => array('default', 'primary', 'success', 'info', 'warning', 'danger'),
            'required' => true,
            'default'  => 'default'),

        'icon' => array(
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

        global $label_tag;

        if ($state == DOKU_LEXER_ENTER) {
            $label_tag = (($is_block) ? 'div' : 'span');
            $type      = $attributes['type'];
            $icon      = $attributes['icon'];

            $markup = '<' . $label_tag . ' class="bs-wrap bs-wrap-label label label-' . $type . '">';

            if ($icon) {
                $markup .= '<i class="' . $icon . '"></i> ';
            }

            $renderer->doc .= $markup;
            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= "</$label_tag>";
            return true;
        }

        return true;
    }
}
