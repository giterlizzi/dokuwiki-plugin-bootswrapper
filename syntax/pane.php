<?php
/**
 * Bootstrap Wrapper Plugin: Pane
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_pane extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<pane.*?>(?=.*?</pane>)';
    protected $pattern_end    = '</pane>';
    protected $tag_attributes = array(

      'id' => array('type'     => 'string',
                    'values'   => null,
                    'required' => true,
                    'default'  => null),

    );

    function getPType(){ return 'block'; }

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $id     = $attributes['id'];
                    $style = $this->getStylingAttributes($attributes);

                    $markup = sprintf('<div role="tabpanel" class="bs-wrap bs-wrap-tab-pane tab-pane %s" id="%s" style="%s">',
                      $style['class'], $id, $style['style']);

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
