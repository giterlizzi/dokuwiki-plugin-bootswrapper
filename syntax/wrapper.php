<?php
/**
 * Bootstrap Wrapper Plugin: Generic Wrapper (span or div)
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_wrapper extends syntax_plugin_bootswrapper_bootstrap {

  protected $pattern_start = '<(?:WRAPPER|wrapper).*?>(?=.*?</(?:WRAPPER|wrapper)>)';
  protected $pattern_end   = '</(?:WRAPPER|wrapper)>';

  function render($mode, Doku_Renderer $renderer, $data) {

    if (empty($data)) return false;

    if ($mode !== 'xhtml') return false;

    /** @var Doku_Renderer_xhtml $renderer */
    list($state, $match, $attributes, $is_block) = $data;

    global $wrapper_tag;

    switch($state) {

      case DOKU_LEXER_ENTER:

        $wrapper_tag = ($is_block) ? 'div' : 'span';
        $id          = '';
        $classes     = implode(' ', $attributes['class']);
        $style       = implode(';', $attributes['style']);
        $markup      = sprintf('<%s id="%s" class="%s" style="%s">', $tag, $id, $classes, $styles);

        $renderer->doc .= $markup;
        return true;

      case DOKU_LEXER_EXIT:
        $renderer->doc .= "</$wrapper_tag>";
        return true;

    }

    return false;

  }

}
