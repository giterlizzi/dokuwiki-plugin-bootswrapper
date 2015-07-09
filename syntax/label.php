<?php
/**
 * Bootstrap Wrapper Plugin: Label
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_label extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<(?:LABEL|label).*?>(?=.*?</(?:LABEL|label)>)';
    protected $pattern_end   = '</(?:LABEL|label)>';

    function getPType() { return 'normal';}

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $type     = ($attributes['type']) ? $attributes['type'] : 'default';
                    $icon     = ($attributes['icon']) ? $attributes['icon'] : null;

                    if (! in_array($type, array('default', 'primary', 'success', 'info', 'warning', 'danger'))) {
                        $type = 'default';
                    }

                    $markup = sprintf('<span class="label label-%s">', $type);

                    if ($icon) {
                      $markup .= sprintf('<i class="%s"></i> ', $icon);
                    }

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
