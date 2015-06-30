<?php
/**
 * Bootstrap Wrapper Plugin: Thumbnail
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_thumbnail extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<(?:THUMBNAIL|thumbnail).*?>(?=.*?</(?:THUMBNAIL|thumbnail)>)';
    protected $pattern_end   = '</(?:THUMBNAIL|thumbnail)>';
    protected $tag           = 'THUMBNAIL';

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $content, $classes, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $markup = '<div class="thumbnail">';

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_UNMATCHED:
                    $renderer->doc .= $content;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= '</div>';
                    return true;

            }

            return true;

        }

        return false;

    }

}
