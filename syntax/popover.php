<?php
/**
 * Bootstrap Wrapper Plugin: Popover
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Jos Roossien <mail@jroossien.com>
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_popover extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'normal';
    public $pattern_start  = '<popover.*?>(?=.*?</popover>)';
    public $pattern_end    = '</popover>';
    public $tag_name       = 'popover';
    public $tag_attributes = array(

        'placement'  => array(
            'type'     => 'string',
            'values'   => array('top', 'bottom', 'left', 'right', 'auto', 'auto top', 'auto bottom', 'auto left', 'auto right'),
            'required' => true,
            'default'  => 'right'),

        'title'      => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),

        'content'    => array(
            'type'     => 'string',
            'values'   => null,
            'required' => true,
            'default'  => null),

        'trigger'    => array(
            'type'     => 'multiple',
            'values'   => array('click', 'hover', 'focus'),
            'required' => true,
            'default'  => 'click'),

        'html'       => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

        'animation'  => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => true),

        'delay'      => array(
            'type'     => 'integer',
            'values'   => null,
            'required' => false,
            'default'  => 0),

        'delay-show' => array(
            'type'     => 'integer',
            'values'   => null,
            'required' => false,
            'default'  => 0),

        'delay-hide' => array(
            'type'     => 'integer',
            'values'   => null,
            'required' => false,
            'default'  => 0),

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
        $data = array_pad($data, 4, null);
        list($state, $match, $pos, $attributes) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            $html5_data = array();

            extract($attributes);

            if (isset($html)) {
                $title   = hsc(p_render('xhtml', p_get_instructions($title), $info));
                $content = hsc(p_render('xhtml', p_get_instructions($content), $info));
            }

            if (isset($trigger)) {
                $html5_data[] = 'data-trigger="' . $trigger . '"';
            }

            if (isset($animation)) {
                $html5_data[] = 'data-animation="' . $animation . '"';
            }

            if (isset($html)) {
                $html5_data[] = 'data-html="' . $html . '"';
            }

            if (isset($placement)) {
                $html5_data[] = 'data-placement="' . $placement . '"';
            }

            if (isset($content)) {
                $html5_data[] = 'data-content="' . $content . '"';
            }

            if (isset($delay)) {
                $html5_data[] = 'data-delay="' . $delay . '"';
            }

            $delay = null;
            if (!$delay && is_array($attributes) && (isset($attributes['delay-hide']) || isset($attributes['delay-show']))) {
                $delays = array();
                $show   = $attributes['delay-show'];
                $hide   = $attributes['delay-hide'];

                if ($hide) {
                    $delays['hide'] = $hide;
                }

                if ($show) {
                    $delays['show'] = $show;
                }

                $html5_data[] = "data-delay='" . json_encode($delays) . "'";
            }

            $markup = '<span class="bs-wrap bs-wrap-popover" data-toggle="popover" title="' . $title . '" ' . implode(' ', $html5_data) . '>';

            $renderer->doc .= $markup;

            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= '</span>';
            return true;
        }

        return true;
    }
}
