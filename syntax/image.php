<?php
/**
 * Bootstrap Wrapper Plugin: Image
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_image extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<image.*?>(?=.*?</image>)';
    protected $pattern_end    = '</image>';
    protected $tag_attributes = array(
      'shape' => array('type'    => 'string',
                       'values'   => array('rounded', 'circle', 'thumbnail', 'responsive'),
                       'required' => false,
                       'default'  => ''),
    );

    function getPType(){ return 'block'; }

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    extract($attributes);

                    $style = $this->getStylingAttributes($attributes);
                    $html5_data = array();

                    if ($shape) {
                        $html5_data[] = sprintf('data-img-shape="%s"', $shape);
                    }

                    $markup = sprintf('<span class="bs-wrap bs-wrap-image %s" id="%s" style="%s" %s>',
                      $style['class'], $style['id'], $style['style'], implode(' ', $html5_data));

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
