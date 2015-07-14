<?php
/**
 * Bootstrap Wrapper Plugin: Image
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_image extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<image.*?>(?=.*?</image>)';
    protected $pattern_end    = '</image>';

    function getPType(){ return 'block'; }

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $type = ($attributes['type']) ? $attributes['type'] : '';

                    if (! in_array($type, array('rounded', 'circle', 'thumbnail', 'responsive'))) {
                        $type = null;
                    }

                    $html5_data = array();

                    if ($type) {
                        $html5_data[] = sprintf('data-img-type="%s"', $type);
                    }

                    $markup = sprintf('<span class="bs-wrap" %s>', implode(' ', $html5_data));

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
