<?php
/**
 * Bootstrap Wrapper Plugin: Button
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_button extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<(?:btn|button).*?>(?=.*?</(?:btn|button)>)';
    protected $pattern_end    = '</(?:btn|button)>';
    protected $tag_attributes = array(

      'type'      => array('type'     => 'string',
                           'values'   => array('default', 'primary', 'success', 'info', 'warning', 'danger', 'link'),
                           'required' => true,
                           'default'  => 'default'),

      'size'      => array('type'     => 'string',
                           'values'   => array('lg', 'sm', 'xs'),
                           'required' => false,
                           'default'  => null),

      'icon'      => array('type'     => 'string',
                           'values'   => null,
                           'required' => false,
                           'default'  => null),

      'collapse'  => array('type'     => 'string',
                           'values'   => null,
                           'required' => false,
                           'default'  => null),

    );

    function getPType() { return 'normal';}

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $html5data = array();

                    foreach ($attributes as $key => $value) {
                      $html5data[] = sprintf('data-btn-%s="%s"', $key, $value);
                    }

                    $markup = sprintf('<span class="bs-wrap bs-wrap-button" %s>', implode(' ', $html5data));

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= "</span>";
                    return true;

            }

            return true;

        }

        return false;

    }

}
