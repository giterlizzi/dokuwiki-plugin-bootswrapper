<?php
/**
 * Bootstrap Wrapper Plugin: Badge
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_badge extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<badge>';
    protected $pattern_end   = '</badge>';

    protected $template_start = '<span class="bs-wrap bs-wrap-badge badge">';
    protected $template_end   = '</span>';

    function getPType() { return 'normal';}

}
