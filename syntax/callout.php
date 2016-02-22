<?php
/**
 * Bootstrap Wrapper Plugin: Callout
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_callout extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<callout.*?>(?=.*?</callout>)';
    protected $pattern_end    = '</callout>';
    protected $tag_attributes = array(

      'type' =>  array('type'     => 'string',
                       'values'   => array('default', 'primary', 'success', 'info', 'warning', 'danger'),
                       'required' => true,
                       'default'  => 'default'),

      'title' => array('type'     => 'string',
                       'values'   => null,
                       'required' => false,
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

                    $type = $attributes['type'];
                    $style = $this->getStylingAttributes($attributes);

                    $markup = sprintf('<div class="bs-wrap bs-callout bs-callout-%s %s" id="%s" style="%s">',
                      $type, $style['class'], $style['id'], $style['style']);

                    if ($title = $attributes['title']) {
                      $markup .= "<h4>$title</h4>";
                    }

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
