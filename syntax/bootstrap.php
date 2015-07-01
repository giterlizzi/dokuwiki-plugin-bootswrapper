<?php
/**
 * Bootstrap Wrapper Plugin
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

class syntax_plugin_bootswrapper_bootstrap extends DokuWiki_Syntax_Plugin {

    protected $pattern_start    = '<BOOTSTRAP.+?>';
    protected $pattern_end      = '</BOOTSTRAP>';
    protected $template_start   = '<div class="%s">';
    protected $template_content = '%s';
    protected $template_end     = '</div>';


    function getType(){ return 'formatting'; }
    function getAllowedTypes() { return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs'); }
    function getPType(){ return 'block';}
    function getSort(){ return 195; }


    function connectTo($mode) {
        $this->Lexer->addEntryPattern($this->pattern_start, $mode, 'plugin_bootswrapper_'.$this->getPluginComponent());
    }

    public function postConnect() {
        $this->Lexer->addExitPattern($this->pattern_end, 'plugin_bootswrapper_'.$this->getPluginComponent());
    }

    function handle($match, $state, $pos, Doku_Handler $handler) {

        switch ($state) {

            case DOKU_LEXER_ENTER :

                $attributes = array();
                $xml        = simplexml_load_string(str_replace('>', '/>', $match));

                foreach ($xml->attributes() as $key => $value) {
                  $attributes[$key] = (string) $value;
                }

                return array($state, $match, $attributes);

            case DOKU_LEXER_UNMATCHED :  return array($state, $match);
            case DOKU_LEXER_EXIT :       return array($state, '');
        }

        return array();

    }

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:
                    $markup = $this->template_start;
                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_UNMATCHED:
                    $renderer->doc .= sprintf($this->template_content,
                                              str_replace(array('<p>','</p>'), '',
                                                          p_render("xhtml", p_get_instructions($match), $info)));
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= $this->template_end;
                    return true;

            }

            return true;

        }

        return false;

    }

}
