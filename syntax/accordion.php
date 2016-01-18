<?php
/**
 * Bootstrap Wrapper Plugin: Panel Group (Accordion)
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_accordion extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<accordion>';
    protected $pattern_end    = '</accordion>';

    protected $tag_attributes = array(

      'id' => array('type'     => 'string',
                    'values'   => null,
                    'required' => true,
                    'default'  => null),

    );

    function getPType() { return 'block'; }

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $id     = $attributes['id'];
                    $markup = sprintf('<div class="bs-wrap bs-wrap-accordion panel-group" id="%s">', $id);

                    $renderer->doc .= $markup;
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
