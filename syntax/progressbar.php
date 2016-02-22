<?php
/**
 * Bootstrap Wrapper Plugin: Progress Bar
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     HavocKKS
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_progressbar extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<(?:bar).*?>(?=.*?</(?:bar)>)';
    protected $pattern_end    = '</(?:bar)>';
    protected $tag_attributes = array(

        'type'     => array('type'     => 'string',
                            'values'   => array('success', 'info', 'warning', 'danger'),
                            'required' => false,
                            'default'  => 'info'),

        'value'    => array('type'     => 'string',
                            'values'   => null,
                            'required' => true,
                            'default'  => "0"),

        'striped'  => array('type'     => 'string',
                            'values'   => array(0, 1),
                            'required' => false,
                            'default'  => false),

        'showvalue' => array('type'     => 'string',
                            'values'   => array(0, 1),
                            'required' => false,
                            'default'  => false),

        'animate'  => array('type'     => 'string',
                            'values'   => array(0, 1),
                            'required' => false,
                            'default'  => false),
    );

    function getPType(){ return 'block'; }

    function render($mode, Doku_Renderer $renderer, $data) {

        if (empty($data)) return false;

        if ($mode == 'xhtml') {

            /** @var Doku_Renderer_xhtml $renderer */
            list($state, $match, $attributes) = $data;

            switch($state) {

                case DOKU_LEXER_ENTER:

                    extract($attributes);
                    $style = $this->getStylingAttributes($attributes);

                    $classCode = "";

                    if($striped){
                        $classCode = "progress-bar-striped";
                    }

                    if($animate){
                        $classCode .= " active";
                    }

                    $markup = sprintf('<div class="bs-wrap bs-wrap-progress-bar progress-bar progress-bar-%s %s %s" id="%s" role="progressbar" aria-valuenow="%s" aria-valuemin="0" aria-valuemax="100" style="width: %s%%;%s %s">',
                                      $type, $classCode, $style['class'], $style['id'], $value, $value, ($showvalue ? 'min-width: 2em;' : ''), $style['style']);

                    if ($showvalue){
                        $markup .= sprintf('%s%% ', $value);
                    } else {
                        $markup .= sprintf('<span class="sr-only">%s%%</span> ', $value);
                    }

                    $renderer->doc .= $markup;
                    return true;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= '</div>';
                    return true;

            }

            return true;

        }

        return false;

    }

}
