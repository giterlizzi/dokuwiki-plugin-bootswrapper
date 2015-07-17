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
    protected $tag_attributes = array(

      'type'      => array('type'     => 'string',
                           'values'   => array('default', 'primary', 'success', 'info', 'warning', 'danger'),
                           'required' => true,
                           'default'  => 'default'),

      'icon'      => array('type'     => 'string',
                           'values'   => null,
                           'required' => false,
                           'default'  => null),

    );

    function getPType() { return 'normal';}

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes, $is_block) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $label_tag = (($is_block) ? 'div' : 'span');
                    $type      = $attributes['type'];
                    $icon      = $attributes['icon'];

                    $markup = sprintf('<%s class="bs-wrap label label-%s">', $label_tag, $type);

                    if ($icon) {
                      $markup .= sprintf('<i class="%s"></i> ', $icon);
                    }

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= "</$label_tag>";
                    return true;

            }

            return true;

        }

        return false;

    }

}
