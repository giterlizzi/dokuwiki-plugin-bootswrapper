<?php
/**
 * Bootstrap Wrapper Plugin: Useful Macros
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_macros extends DokuWiki_Syntax_Plugin
{

    private $macros = array(
        '~~CLEARFIX~~',
        '~~PAGEBREAK~~',
    );

    public function getType()
    {
        return 'substition';
    }

    public function getSort()
    {
        return 99;
    }

    public function getPType()
    {
        return 'normal';
    }

    public function connectTo($mode)
    {

        foreach ($this->macros as $macro) {
            $this->Lexer->addSpecialPattern($macro, $mode, 'plugin_bootswrapper_macros');
        }

    }

    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        return array($match, $state, $pos);
    }

    public function render($mode, Doku_Renderer $renderer, $data)
    {
        if (empty($data)) {
            return false;
        }

        if ($mode !== 'xhtml') {
            return false;
        }

        list($match, $state, $pos) = $data;

        switch ($match) {
            case '~~CLEARFIX~~':
                $renderer->doc .= '<span class="clearfix"></span>';
                break;
            case '~~PAGEBREAK~~':
                $renderer->doc .= '<span class="bs-page-break"></span>';
                break;
        }
    }
}
