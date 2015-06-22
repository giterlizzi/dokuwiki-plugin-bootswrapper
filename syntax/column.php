<?php
/**
 * Bootstrap Wrapper Plugin: Column
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_column extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<(?:COL|col).*?>(?=.*?</(?:COL|col)>)';
    protected $pattern_end   = '</(?:COL|col)>';
    protected $tag           = 'COL';

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $content, $classes, $attributes) = $data;
            $wrap = isset($attributes['wrap']) ? $attributes['wrap'] : 'div';
            $col  = '';

            foreach (array('lg', 'md', 'sm', 'xs') as $device) {
                $col .= isset($attributes[$device]) ? 'col-' . $device . '-' . $attributes[$device] . ' ' : '';
            }

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $markup = sprintf('<%s class="%s">', $wrap, trim($col));

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_UNMATCHED:
                    $renderer->doc .= $content;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= "</$wrap>";
                    return true;

            }

            return true;

        }

        return false;

    }

}
