<?php
/**
 * Bootstrap Wrapper Plugin: Grid
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_grid extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<grid>';
    protected $pattern_end   = '</grid>';

    protected $template_start = '<div class="bs-wrap bs-wrap-row row">';
    protected $template_end   = '</div>';

    function getPType(){ return 'block'; }
}
