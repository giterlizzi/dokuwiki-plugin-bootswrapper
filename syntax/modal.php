<?php
/**
 * Bootstrap Wrapper Plugin: Alert
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Jos Roossien <mail@jroossien.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_modal extends syntax_plugin_bootswrapper_bootstrap {

  protected $pattern_start  = '<modal.*?>(?=.*?</modal>)';
  protected $pattern_end    = '</modal>';
  protected $tag_attributes = array(

    'id'        => array('type'     => 'string',
                          'values'   => null,
                          'required' => true,
                          'default'  => null),

    'size'      => array('type'     => 'string',
                          'values'   => array('lg', 'sm'),
                          'required' => false,
                          'default'  => 'lg'),

    'title'     => array('type'     => 'string',
                          'values'   => null,
                          'required' => false,
                          'default'  => null),

    'keyboard'  => array('type'     => 'boolean',
                          'values'   => array(0, 1),
                          'required' => false,
                          'default'  => true),

    'dismiss'   => array('type'     => 'boolean',
                          'values'   => array(0, 1),
                          'required' => false,
                          'default'  => true),

    'show'      => array('type'     => 'boolean',
                          'values'   => array(0, 1),
                          'required' => false,
                          'default'  => false),

    'fade'      => array('type'     => 'boolean',
                          'values'   => array(0, 1),
                          'required' => false,
                          'default'  => true),

    'backdrop'  => array('type'     => 'string',
                          'values'   => array('true', 'false', 'static'),
                          'required' => false,
                          'default'  => true),

    'remote'     => array('type'     => 'string',
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

          $id       = $attributes['id'];
          $size     = $attributes['size'];
          $title    = $attributes['title'];
          $keyboard = $attributes['keyboard'];
          $dismiss  = $attributes['dismiss'];
          $show     = $attributes['show'];
          $fade     = $attributes['fade'] === true ? 'fade' : '';
          $backdrop = $attributes['backdrop'];
          $remote   = $attributes['remote'];

          if ($remote) {
            $remote = sprintf(' data-remote="%s"', wl($remote, array('do' => 'export_xhtmlbody'), true));
          }

          //Modal
          $markup = sprintf('<div class="bs-wrap bs-wrap-modal modal %s" id="%s" role="dialog" tabindex="-1" aria-labelledby="%s" data-show="%s" data-backdrop="%s" data-keyboard="%s"%s>',
            $fade, $id, $title, $show, $backdrop, $keyboard, $remote);
          $markup .= sprintf('<div class="bs-wrap modal-dialog modal-%s" role="document"><div class="bs-wrap modal-content">', $size);

          //Header/Title
          if ($title) {
            $markup .= '<div class="bs-wrap modal-header">';
            if ($dismiss === true) {
              $markup .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            }
            $markup .= sprintf('<h4 class="bs-wrap modal-title">%s</h4>', $title);
            $markup .= '</div>';
          }

          //Body
          $markup .= '<div class="bs-wrap modal-body">';
          if ($dismiss === true && !$title) {
            //Show dismiss button in body when there is no header.
            $markup .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          }

          $renderer->doc .= $markup;
          return true;

          case DOKU_LEXER_EXIT:
            $renderer->doc .= '</div></div></div></div>';
            return true;

      }

      return true;

    }

    return false;

  }

}
