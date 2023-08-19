<?php
/**
 * Bootstrap Wrapper Plugin: Text
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_text extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'normal';
    public $pattern_start  = '<(?:TEXT|text).*?>(?=.*?</(?:TEXT|text)>)';
    public $pattern_end    = '</(?:TEXT|text)>';
    public $tag_name       = 'text';
    public $tag_attributes = array(

        'type'       => array(
            'type'     => 'string',
            'values'   => array('muted', 'primary', 'success', 'info', 'warning', 'danger'),
            'required' => false,
            'default'  => null),

        'size'       => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'background' => array(
            'type'     => 'string',
            'values'   => array('primary', 'success', 'info', 'warning', 'danger'),
            'required' => false,
            'default'  => null),

        'align'      => array(
            'type'     => 'string',
            'values'   => array('left', 'center', 'right', 'justify', 'nowrap'),
            'required' => false,
            'default'  => null),

        'transform'  => array(
            'type'     => 'string',
            'values'   => array('lowercase', 'uppercase', 'capitalize'),
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
        $data = array_pad($data, 5, null);
        list($state, $match, $pos, $attributes, $is_block) = $data;

        global $text_tag;

        if ($state == DOKU_LEXER_ENTER) {
            $text_tag   = (($is_block) ? 'div' : 'span');
            $color      = (isset($attributes['type']) ? $attributes['type'] : null);
            $size       = (isset($attributes['size']) ? $attributes['size'] : null);
            $background = (isset($attributes['background']) ? $attributes['background'] : null);
            $align      = (isset($attributes['align']) ? $attributes['align'] : null);
            $transform  = (isset($attributes['transform']) ? $attributes['transform'] : null);

            $classes = array();
            $styles  = array();

            $classes[] = 'bs-wrap';
            $classes[] = 'bs-wrap-text';
            $classes[] = 'text';

            if ($align && $is_block) {
                $classes[] = "text-$align";
            }

            if ($color) {
                $classes[] = "text-$color";
            }

            if ($transform) {
                $classes[] = "text-$transform";
            }

            if ($background) {
                $classes[] = "bg-$background";
            }

            if ($size) {
                if (strtolower($size) == 'small') {
                    $classes[] = 'small';
                } else {
                    $styles['font-size'] = $size;
                }
            }

            $text_attributes = $this->buildAttributes(array(
                'class' => $classes,
                'style' => $styles
            ));

            $markup = "<$text_tag $text_attributes>";

            $renderer->doc .= $markup;
            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= "</$text_tag>";
            return true;
        }

        return true;
    }
}
