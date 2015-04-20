<?php
/**
 * Bootstrap Wrapper Plugin: Jumbotron
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_jumbotron extends syntax_plugin_bootswrapper_bootstrap {
    protected $pattern_start    = '<(?:JUMBOTRON|jumbotron)>';
    protected $pattern_end      = '</(?:JUMBOTRON|jumbotron)>';
    protected $tag              = 'JUMBOTRON';
    protected $template_start   = '<div class="jumbotron"><div class="container">';
    protected $template_content = '%s';
    protected $template_end     = '</div></div>';
}
