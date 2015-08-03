<?php
/**
 * Bootstrap Wrapper Plugin: Progress
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     HavocKKS
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_progress extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start  = '<progress>';
    protected $pattern_end    = '</progress>';

    protected $template_start = '<div class="bs-wrap bs-wrap-progress progress">';
    protected $template_end   = '</div>';

}
