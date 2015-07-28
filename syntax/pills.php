<?php
/**
 * Bootstrap Wrapper Plugin: Pills (nav alias)
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_pills extends syntax_plugin_bootswrapper_nav {

    protected $pattern_start = '<pills.*?>(?=.*?</pills>)';
    protected $pattern_end   = '</pills>';

    protected $type = 'pills';

}
