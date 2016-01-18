<?php
/**
 * Bootstrap Wrapper Plugin: Affix
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_affix extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<affix.*?>(?=.*?</affix>)';
    protected $pattern_end    = '</affix>';
    protected $tag_attributes = array(

        'offset-top'      => array( 'type'     => 'integer',
                                    'values'   => null,
                                    'required' => false,
                                    'default'  => null),
  
        'offset-bottom'   => array( 'type'     => 'integer',
                                    'values'   => null,
                                    'required' => false,
                                    'default'  => null),

        'target'          => array( 'type'     => 'string',
                                    'values'   => null,
                                    'required' => false,
                                    'default'  => null),


    );

    function getPType() { return 'block';}


    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $top    = $attributes['offset-top'];
                    $bottom = $attributes['offset-bottom'];
                    $target = $attributes['target'];
                    $data   = array();

                    if ($top) {
                        $data[] = "data-offset-top=$top ";
                    }
                    if ($bottom) {
                        $data[] = "data-offset-bottom=$bottom ";
                    }
                    if ($target) {
                        $data[] = sprintf('data-target="%s"', $target);
                    }

                    $markup = sprintf('<div style="z-index:1024" class="bs-wrap bs-wrap-affix" data-spy="affix" %s>', implode(' ', $data));

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
