<?php
/**
 * Bootstrap Wrapper Plugin: Carousel - Slide
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(dirname(__FILE__).'/bootstrap.php');

class syntax_plugin_bootswrapper_slide extends syntax_plugin_bootswrapper_bootstrap {

    protected $pattern_start = '<slide.*?>(?=.*?</slide>)';
    protected $pattern_end   = '</slide>';

    protected $template_start = '<div class="bs-wrap bs-wrap-slide item %s" id="%s" style="%s">';
    protected $template_end   = '</div>';

    function getPType(){ return 'block'; }

}
