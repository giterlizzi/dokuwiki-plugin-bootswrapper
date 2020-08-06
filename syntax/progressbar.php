<?php
/**
 * Bootstrap Wrapper Plugin: Progress Bar
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     HavocKKS
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_progressbar extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<(?:bar).*?>(?=.*?</(?:bar)>)';
    public $pattern_end    = '</(?:bar)>';
    public $tag_name       = 'bar';
    public $tag_attributes = array(

        'type'      => array(
            'type'     => 'string',
            'values'   => array('success', 'info', 'warning', 'danger'),
            'required' => false,
            'default'  => 'info'),

        'value'     => array(
            'type'     => 'integer',
            'min'      => 0,
            'max'      => 100,
            'values'   => null,
            'required' => true,
            'default'  => 0),

        'striped'   => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

        'showvalue' => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

        'animate'   => array(
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

        if ($state == DOKU_LEXER_ENTER) {
            $classes   = "";
            $striped   = (isset($attributes['striped']) ? $attributes['striped'] : $this->tag_attributes['striped']['default']);
            $animate   = (isset($attributes['animate']) ? $attributes['animate'] : $this->tag_attributes['animate']['default']);
            $showvalue = (isset($attributes['showvalue']) ? $attributes['showvalue'] : $this->tag_attributes['showvalue']['default']);
            $value     = (isset($attributes['value']) ? $attributes['value'] : $this->tag_attributes['value']['default']);
            $type      = (isset($attributes['type']) ? $attributes['type'] : $this->tag_attributes['type']['default']);

            if ($striped) {
                $classes = "progress-bar-striped";
            }

            if ($animate) {
                $classes .= " active";
            }

            $markup = '<div class="bs-wrap bs-wrap-progress-bar progress-bar progress-bar-' . $type . ' ' . $classes . '" role="progressbar" aria-valuenow="' . $value . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $value . '%;' . ($showvalue ? 'min-width: 2em;' : '') . '">';

            if ($showvalue) {
                $markup .= "$value%";
            } else {
                $markup .= '<span class="sr-only">' . $value . '%</span> ';
            }

            $renderer->doc .= $markup;

            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= '</div>';
            return true;
        }

        return true;
    }
}
