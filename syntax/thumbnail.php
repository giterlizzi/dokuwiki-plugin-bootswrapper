<?php
/**
 * Bootstrap Wrapper Plugin: Thumbnail
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_thumbnail extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<thumbnail>';
    protected $pattern_end   = '</thumbnail>';

    protected $template_start = '<div class="bs-wrap bs-wrap-thumbnail thumbnail">';
    protected $template_end   = '</div>';

    function getPType(){ return 'block'; }

}
