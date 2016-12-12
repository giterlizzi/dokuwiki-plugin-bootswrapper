<?php
/**
 * Bootstrap Wrapper Plugin: Text
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_text extends syntax_plugin_bootswrapper_bootstrap {

  protected $pattern_start = '<(?:TEXT|text).*?>(?=.*?</(?:TEXT|text)>)';
  protected $pattern_end   = '</(?:TEXT|text)>';
  protected $tag_attributes = array(

    'type'       => array('type'     => 'string',
                          'values'   => array('muted', 'primary', 'success', 'info', 'warning', 'danger'),
                          'required' => false,
                          'default'  => null),

    'size'       => array('type'     => 'string',
                          'values'   => null,
                          'required' => false,
                          'default'  => null),

    'background' => array('type'     => 'string',
                          'values'   => array('primary', 'success', 'info', 'warning', 'danger'),
                          'required' => false,
                          'default'  => null),

    'align'      => array('type'     => 'string',
                          'values'   => array('left', 'center', 'right', 'justify', 'nowrap'),
                          'required' => false,
                          'default'  => null),

    'transform'  => array('type'     => 'string',
                          'values'   => array('lowercase', 'uppercase', 'capitalize'),
                          'required' => false,
                          'default'  => null),

  );

  function getPType() { return 'block'; }

  function render($mode, Doku_Renderer $renderer, $data) {

    if (empty($data)) return false;

    if ($mode == 'xhtml') {

      /** @var Doku_Renderer_xhtml $renderer */
      list($state, $match, $attributes, $is_block) = $data;

      global $text_tag;

      switch($state) {

        case DOKU_LEXER_ENTER:

          $text_tag   = (($is_block) ? 'div' : 'span');
          $color      = $attributes['type'];
          $size       = $attributes['size'];
          $background = $attributes['background'];
          $align      = $attributes['align'];
          $transform  = $attributes['transform'];

          $classes = array();
          $styles  = array();

          if ($align && $is_block) { $classes[] = "text-$align"; }
          if ($color)              { $classes[] = "text-$color"; }
          if ($transform)          { $classes[] = "text-$transform"; }
          if ($background)         { $classes[] = "bg-$background"; }

          if ($size) {

            if (strtolower($size) == 'small') {
              $classes[] = 'small';
            } else {
              $styles[] = sprintf('font-size:%s', $size);
            }

          }

          $markup = sprintf('<%s class="bs-wrap bs-wrap-text text %s" style="%s">',
                            $text_tag,
                            implode(' ', $classes),
                            implode(';', $styles));

          $renderer->doc .= $markup;
          return true;

        case DOKU_LEXER_EXIT:
          $renderer->doc .= "</$text_tag>";
          return true;

      }

      return true;

    }

    return false;

  }

}
