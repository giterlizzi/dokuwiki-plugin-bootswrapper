<?php
/**
 * Bootstrap Wrapper Plugin: Pane
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_pane extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<pane[\s].*?>(?=.*?</pane>)';
    public $pattern_end    = '</pane>';
    public $tag_name       = 'pane';
    public $tag_attributes = array(

        'id' => array(
            'type'     => 'string',
            'values'   => null,
            'required' => true,
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
            $id     = $attributes['id'];
            $markup = '<div role="tabpanel" class="bs-wrap bs-wrap-tab-pane tab-pane" id="' . $id . '">';

            $renderer->doc .= $markup;

            if (defined('SEC_EDIT_PATTERN')) { // for DokuWiki Greebo and more recent versions
                $renderer->startSectionEdit($pos, array('target' => 'plugin_bootswrapper_pane', 'name' => $state));
            } else {
                $renderer->startSectionEdit($pos, 'plugin_bootswrapper_pane', $state);
            }

            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->finishSectionEdit($pos + strlen($match));
            $renderer->doc .= '</div>';

            return true;
        }

        return true;
    }
}
