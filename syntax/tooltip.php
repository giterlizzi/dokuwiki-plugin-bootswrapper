<?php
/**
 * Bootstrap Wrapper Plugin: Tooltip
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_tooltip extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<(?:TOOLTIP|tooltip).*?>(?=.*?</(?:TOOLTIP|tooltip)>)';
    protected $pattern_end   = '</(?:TOOLTIP|tooltip)>';

    function getPType() { return 'normal';}

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $location = ($attributes['location']) ? $attributes['location'] : 'top';
                    $title    = ($attributes['title'])    ? $attributes['title']    : null;

                    if (! in_array($location, array('top', 'bottom', 'left', 'right', 'auto'))) {
                        $type = 'top';
                    }

                    $markup = sprintf('<span data-toggle="tooltip" data-html="true" data-placement="%s" title="%s" style="border-bottom:1px dotted">', $location, $title);

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= '</span>';
                    return true;

            }

            return true;

        }

        return false;

    }

}
