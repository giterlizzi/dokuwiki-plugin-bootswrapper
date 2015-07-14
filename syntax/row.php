<?php
/**
 * Bootstrap Wrapper Plugin: Row (grid alias)
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_row extends syntax_plugin_bootswrapper_grid {

    protected $pattern_start = '<row>';
    protected $pattern_end   = '</row>';

}
