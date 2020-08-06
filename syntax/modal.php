<?php
/**
 * Bootstrap Wrapper Plugin: Alert
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @author     Jos Roossien <mail@jroossien.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_modal extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'normal';
    public $pattern_start  = '<modal.*?>(?=.*?</modal>)';
    public $pattern_end    = '</modal>';
    public $tag_name       = 'modal';
    public $tag_attributes = array(

        'id'       => array(
            'type'     => 'string',
            'values'   => null,
            'required' => true,
            'default'  => null),

        'size'     => array(
            'type'     => 'string',
            'values'   => array('lg', 'sm'),
            'required' => false,
            'default'  => null),

        'title'    => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'keyboard' => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => null),

        'dismiss'  => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => true),

        'show'     => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

        'fade'     => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => true),

        'backdrop' => array(
            'type'     => 'string',
            'values'   => array('true', 'false', 'static'),
            'required' => false,
            'default'  => null),

        'remote'   => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

    );

    public function render($mode, Doku_Renderer $renderer, $data)
    {

        if (empty($data)) {
            return false;
        }

        if ($mode !== 'xhtml') {
            return false;
        }

        /** @var Doku_Renderer_xhtml $renderer */
        list($state, $match, $pos, $attributes) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            $id       = $attributes['id'];
            $size     = $attributes['size'];
            $title    = $attributes['title'];
            $keyboard = $attributes['keyboard'];
            $dismiss  = $attributes['dismiss'];
            $show     = $attributes['show'];
            $fade     = $attributes['fade'] === true ? 'fade' : '';
            $backdrop = $attributes['backdrop'];
            $remote   = $attributes['remote'];

            $html5_attributes = array();

            if ($remote) {
                $html5_attributes['data-remote'] = wl($remote, array('do' => 'export_xhtmlbody'), true);
            }

            if ($title) {
                $html5_attributes['data-labelledby'] = $title;
            }

            if ($show) {
                $html5_attributes['data-show'] = $show;
            }

            if ($backdrop) {
                $html5_attributes['data-backdrop'] = $backdrop;
            }

            if ($keyboard) {
                $html5_attributes['data-keyboard'] = $keyboard;
            }

            //Modal
            $markup = '<div class="bs-wrap bs-wrap-modal modal ' . $fade . '" id="' . $id . '" role="dialog" tabindex="-1" ' . $this->buildAttributes($html5_attributes) . '>';

            $markup .= '<div class="bs-wrap modal-dialog modal-' . $size . '" role="document"><div class="bs-wrap modal-content">';

            //Header/Title
            if ($title) {
                $markup .= '<div class="bs-wrap modal-header">';

                if ($dismiss === true) {
                    $markup .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                }

                $markup .= '<h4 class="bs-wrap modal-title">' . $title . '</h4>';
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
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= '</div></div></div></div>';
            return true;
        }

        return true;
    }
}
