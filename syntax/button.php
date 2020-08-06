<?php
/**
 * Bootstrap Wrapper Plugin: Button
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_button extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'normal';
    public $pattern_start  = '<(?:btn|button).*?>(?=.*?</(?:btn|button)>)';
    public $pattern_end    = '</(?:btn|button)>';
    public $tag_name       = 'button';
    public $tag_attributes = array(

        'type'     => array(
            'type'     => 'string',
            'values'   => array('default', 'primary', 'success', 'info', 'warning', 'danger', 'link'),
            'required' => true,
            'default'  => 'default'),

        'size'     => array(
            'type'     => 'string',
            'values'   => array('lg', 'sm', 'xs'),
            'required' => false,
            'default'  => null),

        'icon'     => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'collapse' => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'modal'    => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'block'    => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => null),

        'disabled' => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
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
            $html_attributes            = $this->mergeCoreAttributes($attributes);
            $html_attributes['class'][] = 'bs-wrap bs-wrap-button';

            foreach (array_keys($this->tag_attributes) as $attribute) {
                if (isset($attributes[$attribute])) {
                    $html_attributes["data-btn-$attribute"] = $attributes[$attribute];
                }
            }

            $markup = '<span ' . $this->buildAttributes($html_attributes) . '>';

            $renderer->doc .= $markup;
            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= "</span>";
            return true;
        }

        return true;
    }
}
