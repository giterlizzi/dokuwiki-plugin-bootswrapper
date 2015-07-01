<?php
/**
 * Bootstrap Wrapper Plugin: Panel
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_panel extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<(?:PANEL|panel).*?>(?=.*?</(?:PANEL|panel)>)';
    protected $pattern_end   = '</(?:PANEL|panel)>';

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            global $footer;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    $type     = ($attributes['type'])     ? $attributes['type']     : 'default';
                    $title    = ($attributes['title'])    ? $attributes['title']    : null;
                    $footer   = ($attributes['footer'])   ? $attributes['footer']   : null;
                    $subtitle = ($attributes['subtitle']) ? $attributes['subtitle'] : null;
                    $icon     = ($attributes['icon'])     ? $attributes['icon']     : null;

                    $markup = sprintf('<div class="panel panel-%s">', $type);

                    if ($title || $subtitle) {

                        if ($icon) {
                          $title = sprintf('<i class="%s"></i> %s', $icon, $title);
                        }

                        $markup .= sprintf('<div class="panel-heading"><div class="panel-title">%s</div>%s</div>', $title, $subtitle);

                    }

                    $markup .= '<div class="panel-body">';

                    $renderer->doc .= $markup;

                    return true;

                case DOKU_LEXER_UNMATCHED:
                    $renderer->doc .= sprintf($this->template_content,
                                              str_replace(array('<p>','</p>'), '',
                                                          p_render("xhtml", p_get_instructions($match), $info)));
                    return true;

                case DOKU_LEXER_EXIT:

                    $markup = '</div>';

                    if ($footer) {
                        $markup .= sprintf('<div class="panel-footer">%s</div>', $footer);
                    }

                    $markup .= '</div>';

                    $renderer->doc .= $markup;

                    return true;

            }

            return true;

        }

        return false;

    }

}
