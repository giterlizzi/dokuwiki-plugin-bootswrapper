<?php
/**
 * Bootstrap Wrapper Plugin: Nav (Pills & Tabs)
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_nav extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<nav.*?>(?=.*?</nav>)';
    public $pattern_end    = '</nav>';
    public $nav_type       = null;
    public $tag_name       = 'nav';
    public $tag_attributes = array(

        'type'      => array(
            'type'     => 'string',
            'values'   => array('tabs', 'pills'),
            'required' => true,
            'default'  => 'pills'),

        'stacked'   => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

        'justified' => array(
            'type'     => 'boolean',
            'values'   => array(0, 1),
            'required' => false,
            'default'  => false),

        'fade'      => array(
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
            $html5data = array();

            if (!empty($this->nav_type)) {
                $attributes['type'] = $this->nav_type;
            }

            foreach ($attributes as $key => $value) {
                $html5data[] = 'data-nav-' . $key . '="' . $value . '"';
            }

            $markup = '<div class="bs-wrap bs-wrap-nav" ' . implode(' ', $html5data) . '>';

            $renderer->doc .= $markup;
            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= "</div>";
            return true;
        }

        return true;
    }
}
