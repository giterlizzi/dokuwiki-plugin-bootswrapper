<?php
/**
 * Bootstrap Wrapper Plugin: Page Header
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_pageheader extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<page-header>';
    protected $pattern_end   = '</page-header>';

    protected $template_start = '<div class="bs-wrap page-header">';
    protected $template_end   = '</div>';

}
