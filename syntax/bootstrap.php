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

    protected $header_pattern   = '[ \t]*={2,}[^\n]+={2,}[ \t]*(?=\n)';


    function getType(){ return 'formatting'; }
    function getAllowedTypes() { return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs'); }
    function getPType(){ return 'stack'; }
    function getSort(){ return 195; }


    function connectTo($mode) {
        $this->Lexer->addEntryPattern($this->pattern_start, $mode, 'plugin_bootswrapper_'.$this->getPluginComponent());
    }

    public function postConnect() {
        $this->Lexer->addExitPattern($this->pattern_end, 'plugin_bootswrapper_'.$this->getPluginComponent());
        $this->Lexer->addPattern($this->header_pattern, 'plugin_bootswrapper_'.$this->getPluginComponent());
    }

    function handle($match, $state, $pos, Doku_Handler $handler) {

        switch ($state) {

          case DOKU_LEXER_MATCHED:

              $title = trim($match);
              $level = 7 - strspn($title,'=');
              if($level < 1) $level = 1;
              $title = trim($title,'=');
              $title = trim($title);

              //if( $handler->status['section'] ) $handler->_addCall('section_close',array(), $pos);

              $handler->_addCall('header',array($title,$level,$pos), $pos);

              //$handler->_addCall('section_open',array($level),$pos);
              //$this->status['section'] = true;

              break;

            case DOKU_LEXER_ENTER:

                $attributes = array();
                $xml        = simplexml_load_string(str_replace('>', '/>', $match));
                $tag        = $xml->getName();

                foreach ($xml->attributes() as $key => $value) {
                  $attributes[$key] = (string) $value;
                }

                if ($tag == strtolower($tag)) {
                    $is_block = false;
                }

                if ($tag == strtoupper($tag)) {
                    $is_block = true;
                }

                return array($state, $match, $attributes, $is_block);

            case DOKU_LEXER_UNMATCHED:
                $handler->_addCall('cdata', array($match), $pos);
                //return array($state, $match);
                break;

            case DOKU_LEXER_EXIT:
                return array($state, '');

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

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= $this->template_end;
                    return true;

            }

            return true;

        }

        return false;

    }

}
