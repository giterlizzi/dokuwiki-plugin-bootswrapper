<?php
/**
 * Bootstrap Wrapper Plugin: Caption
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_caption extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<caption.*?>(?=.*?</caption>)';
    protected $pattern_end   = '</caption>';

    protected $template_start = '<div class="bs-wrap bs-wrap-caption caption %s" id="%s" style="%s">';
    protected $template_end   = '</div>';

    function getPType() { return 'block';}

}
