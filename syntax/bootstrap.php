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
    protected $tag              = 'BOOTSTRAP';
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

                $search  = array('<'.$this->tag.'>', '</'.$this->tag.'>');
                $content = trim(str_replace($search, '', $match));
                $classes = (array) explode(' ', trim(str_replace(array('<'.$this->tag, '>'), '', $match)));
                $attributes = array();

                //preg_match_all("/([a-z0-9_]+)\s*=\s*[\"\'](.*?)[\"\']/is", trim(str_replace(array('<'.$this->tag, '>'), '', $match)), $out);
                $xml = simplexml_load_string(str_replace('>', '/>', $match));

                //for ($i=0; $i < count($out[1]); $i++) {
                foreach ($xml->attributes() as $key => $value) {
                  //$attributes[$out[1][$i]] = $out[2][$i];
                  $attributes[$key] = (string) $value;
                }

                return array($state, $content, $classes, $attributes);

            case DOKU_LEXER_UNMATCHED :  return array($state, $match);
            case DOKU_LEXER_EXIT :       return array($state, '');
        }

        return array();

    }

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $content, $classes, ) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:
                    $markup = sprintf($this->template_start, @implode(' ', $classes));
                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_UNMATCHED:
                    $renderer->doc .= sprintf($this->template_content,
                                              str_replace(array('<p>','</p>'), '',
                                                          p_render("xhtml", p_get_instructions($content), $info)));
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= sprintf($this->template_end, '');
                    return true;

            }

            return true;

        }

        return false;

    }

}
