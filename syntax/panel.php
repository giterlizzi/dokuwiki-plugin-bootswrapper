<?php
/**
 * Bootstrap Wrapper Plugin: Panel
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_panel extends syntax_plugin_bootswrapper_bootstrap
{

    public $pattern_start  = '<panel.*?>(?=.*?</panel>)';
    public $pattern_end    = '</panel>';
    public $tag_name       = 'panel';
    public $tag_attributes = array(

        'type'     => array(
            'type'     => 'string',
            'values'   => array('default', 'primary', 'success', 'info', 'warning', 'danger'),
            'required' => true,
            'default'  => 'default'),

        'title'    => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'footer'   => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'subtitle' => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'icon'     => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'no-body'  => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

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

        global $nobody, $footer;

        if ($state == DOKU_LEXER_ENTER) {
            $type     = $attributes['type'];
            $title    = (isset($attributes['title']) ? $attributes['title'] : false);
            $footer   = (isset($attributes['footer']) ? $attributes['footer'] : false);
            $subtitle = (isset($attributes['subtitle']) ? $attributes['subtitle'] : false);
            $icon     = (isset($attributes['icon']) ? $attributes['icon'] : false);
            $nobody   = (isset($attributes['no-body']) ? $attributes['no-body'] : false);

            $markup = '<div class="bs-wrap bs-wrap-panel panel panel-' . $type . '">';

            if ($title || $subtitle) {

                if ($icon) {
                    $title = '<i class="' . $icon . '"></i> ' . $title;
                }

                $markup .= '<div class="panel-heading"><h4 class="panel-title">' . $title . '</h4>' . $subtitle . '</div>';

            }

            if (!$nobody) {
                $markup .= '<div class="panel-body">';
            }

            if (defined('SEC_EDIT_PATTERN')) { // for DokuWiki Greebo and more recent versions
                $renderer->startSectionEdit($pos, array('target' => 'plugin_bootswrapper_panel', 'name' => $state));
            } else {
                $renderer->startSectionEdit($pos, 'plugin_bootswrapper_panel', $state);
            }

            $renderer->doc .= $markup;

            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $markup = '';

            if (!$nobody) {
                $markup = '</div>';
            }

            if ($footer) {
                $markup .= '<div class="panel-footer">' . $footer . '</div>';
            }

            $markup .= '</div>';
            $renderer->doc .= $markup;

            $renderer->finishSectionEdit($pos + strlen($match));

            return true;
        }

        return true;
    }
}
