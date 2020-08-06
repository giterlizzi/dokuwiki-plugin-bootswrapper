<?php
/**
 * Bootstrap Wrapper Plugin: Panel Group (Accordion)
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_accordion extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<accordion.*?>(?=.*?</accordion>)';
    public $pattern_end    = '</accordion>';
    public $tag_name       = 'accordion';
    public $tag_attributes = array(

        'id'        => array(
            'type'     => 'string',
            'values'   => null,
            'required' => true,
            'default'  => null),

        'collapsed' => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
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
        list($state, $match, $pos, $pos, $attributes) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            $html_attributes            = $this->mergeCoreAttributes($attributes);
            $html_attributes['class'][] = 'bs-wrap bs-wrap-accordion panel-group';

            if ($attributes['collapsed']) {
                $html_attributes['class'][] = 'bs-wrap-accordion-collapsed';
            }

            $markup_attributes = $this->buildAttributes($html_attributes);
            $markup            = "<div $markup_attributes>";

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
