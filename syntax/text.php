<?php
/**
 * Bootstrap Wrapper Plugin: Text
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_text extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<(?:TEXT|text).*?>(?=.*?</(?:TEXT|text)>)';
    protected $pattern_end   = '</(?:TEXT|text)>';

    function getPType() { return 'normal';}

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes, $is_block) = $data;

            global $text_tag;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $text_tag = (($is_block) ? 'div' : 'span');

                    $color      = ($attributes['type'])       ? strtolower($attributes['type'])       : null;
                    $background = ($attributes['background']) ? strtolower($attributes['background']) : null;
                    $align      = ($attributes['align'])      ? strtolower($attributes['align'])      : null;
                    $transform  = ($attributes['transform'])  ? strtolower($attributes['transform'])  : null;
        
                    if (! in_array($color, array('muted', 'primary', 'success', 'info', 'warning', 'danger'))) {
                        $color = null;
                    }

                    if (! in_array($background, array('primary', 'success', 'info', 'warning', 'danger'))) {
                        $background = null;
                    }
        
                    if (! in_array($align, array('left', 'center', 'right', 'justify', 'nowrap'))) {
                        $align = null;
                    }
        
                    if (! in_array($transform, array('lowercase', 'uppercase', 'capitalize'))) {
                        $transform = null;
                    }
        
                    $classes = array();
        
                    if ($align)      { $classes[] = "text-$align"; }
                    if ($color)      { $classes[] = "text-$color"; }
                    if ($transform)  { $classes[] = "text-$transform"; }
                    if ($background) { $classes[] = "bg-$background"; }

                    $markup = sprintf('<%s class="bs-wrap text %s">', $text_tag, implode(' ', $classes));
                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= "</$text_tag>";
                    return true;

            }

            return true;

        }

        return false;

    }

}
