<?php
/**
 * Bootstrap Wrapper Plugin: Tabs
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_nav extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<nav.*?>(?=.*?</nav>)';
    protected $pattern_end   = '</nav>';

    function getPType() { return 'block';}

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            $html5data = array();

            if (! isset($attributes['type'])) {
              $attributes['type'] = 'tabs';
            }

            foreach ($attributes as $key => $value) {

                if ($key == 'type' && ! in_array($value, array('tabs', 'pills'))) {
                    $value = 'tabs';
                }

                $html5data[] = sprintf('data-nav-%s="%s"', $key, $value);
            }

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $markup = sprintf('<div %s>', implode(' ', $html5data));

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= "</div>";
                    return true;

            }

            return true;

        }

        return false;

    }

}
