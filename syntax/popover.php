<?php
/**
 * Bootstrap Wrapper Plugin: Tooltip
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Jos Roossien <mail@jroossien.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_popover extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<popover.*?>(?=.*?</popover>)';
    protected $pattern_end    = '</popover>';
    protected $tag_attributes = array(

      'placement' => array('type'     => 'string',
                           'values'   => array('top', 'bottom', 'left', 'right', 'auto'),
                           'required' => true,
                           'default'  => 'top'),

      'title'     => array('type'     => 'string',
                           'values'   => null,
                           'required' => false,
                           'default'  => null),

      'content'   => array('type'     => 'string',
                           'values'   => null,
                           'required' => true,
                           'default'  => null),

      'trigger'   => array('type'     => 'string',
                           'values'   => array('click', 'hover', 'focus'),
                           'required' => true,
                           'default'  => 'click'),

      'html'      => array('type'     => 'boolean',
                           'values'   => array(0, 1),
                           'required' => false,
                           'default'  => false),

    );

    function getPType() { return 'normal';}

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $placement = $attributes['placement'];
                    $title     = $attributes['title'];
                    $content   = $attributes['content'];
                    $trigger   = $attributes['trigger'];
                    $html      = $attributes['html'];
                    $style = $this->getStylingAttributes($attributes);

                    if ($html) {
                      $title = hsc(p_render('xhtml',p_get_instructions($title), $info));
                      $content = hsc(p_render('xhtml',p_get_instructions($content), $info));
                    }

                    $markup = sprintf('<span class="bs-wrap bs-wrap-popover %s" id="%s" style="%s" data-toggle="popover" data-trigger="%s" data-html="%s" data-placement="%s" title="%s" data-content="%s">',
                      $style['class'], $style['id'], $style['style'], $trigger, $html, $placement, $title, $content);

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
