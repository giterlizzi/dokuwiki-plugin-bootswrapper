<?php
/**
 * Bootstrap Wrapper Plugin: Page Header
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_pageheader extends syntax_plugin_bootswrapper_bootstrap
{

    public $pattern_start  = '<page-header>';
    public $pattern_end    = '</page-header>';
    public $template_start = '<div class="bs-wrap bs-wrap-page-header page-header">';
    public $template_end   = '</div>';
    public $tag_name       = 'page-header';

}
