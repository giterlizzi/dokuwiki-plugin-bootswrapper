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

  public $pattern_start  = '<pane[\s].*?>(?=.*?</pane>)';
  public $pattern_end    = '</pane>';
  public $tag_name       = 'pane';
  public $tag_attributes = array(

    'id' => array('type'     => 'string',
                  'values'   => null,
                  'required' => true,
                  'default'  => null),

  );

  public function getPType(){ return 'block'; }

  public function render($mode, Doku_Renderer $renderer, $data) {

    if (empty($data)) return false;
    if ($mode !== 'xhtml') return false;

    /** @var Doku_Renderer_xhtml $renderer */
    list($state, $match, $pos, $attributes) = $data;

    switch($state) {

      case DOKU_LEXER_ENTER:

        $id     = $attributes['id'];
        $markup = sprintf('<div role="tabpanel" class="bs-wrap bs-wrap-tab-pane tab-pane" id="%s">', $id);

        $renderer->doc .= $markup;

        if (defined('SEC_EDIT_PATTERN')) { // for DokuWiki Greebo and more recent versions
          $renderer->startSectionEdit($pos, array('target' => 'plugin_bootswrapper_pane', 'name' => $state));
        } else {
          $renderer->startSectionEdit($pos, 'plugin_bootswrapper_pane', $state);
        }

        return true;

      case DOKU_LEXER_EXIT:

        $renderer->finishSectionEdit($pos + strlen($match));
        $renderer->doc .= '</div>';

        return true;

    }

    return true;

  }

}
