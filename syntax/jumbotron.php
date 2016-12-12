<?php
/**
 * Bootstrap Wrapper Plugin: Jumbotron
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>, Eric Maeker <eric@maeker.fr>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_jumbotron extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<(?:JUMBOTRON|jumbotron).*?>(?=.*?</(?:JUMBOTRON|jumbotron)>)';
    protected $pattern_end    = '</(?:JUMBOTRON|jumbotron)>';
    protected $tag_attributes = array(

      'background' => array('type'     => 'string',
                            'values'   => null,
                            'required' => false,
                            'default'  => null),

      'color'      => array('type'     => 'string',
                            'values'   => null,
                            'required' => false,
                            'default'  => null),

      'height'      => array('type'     => 'string',
                            'values'   => null,
                            'required' => false,
                            'default'  => null),

      'padding-top'      => array('type'     => 'string',
                            'values'   => null,
                            'required' => false,
                            'default'  => null),

      'background-size'      => array('type'     => 'string',
                            'values'   => null,
                            'required' => false,
                            'default'  => null),

      'text-shadow'      => array('type'     => 'string',
                            'values'   => null,
                            'required' => false,
                            'default'  => null),
    );

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes, $is_block) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $background = $attributes['background'];
                    $color      = $attributes['color'];
                    $height     = $attributes['height'];
                    $paddingtop = $attributes['padding-top'];
                    $backgroundsize= $attributes['background-size'];
                    $shadow     = $attributes['text-shadow'];

                    $styles = array();

                    if ($background) {
                      $styles[] = sprintf('background-image:url(%s)', ml($background));
                    }

                    if ($color) {
                      $styles[] = sprintf('color:%s', hsc($color));
                    }

                    if ($height) {
                      $styles[] = sprintf('height:%s', $height);
                    }

                    if ($paddingtop) {
                      $styles[] = sprintf('padding-top:%s', $paddingtop);
                    }

                    if ($backgroundsize) {
                      $styles[] = sprintf('background-size:%s', $backgroundsize);
                    }

                    if ($shadow) {
                      $styles[] = sprintf('text-shadow:%s', $shadow);
                    }


                    $markup = sprintf('<div class="bs-wrap bs-wrap-jumbotron jumbotron" style="%s">', implode(';', $styles), $type);
                    $markup .= '<div class="container">';

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= '</div></div>';
                    return true;

            }

            return true;

        }

        return false;

    }

}
