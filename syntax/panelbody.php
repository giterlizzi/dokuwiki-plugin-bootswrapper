<?php
/**
 * Bootstrap Wrapper Plugin: Panel Body
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_panelbody extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<panel-body>';
    public $pattern_end    = '</panel-body>';
    public $template_start = '<div class="bs-wrap bs-wrap-panel-body panel-body">';
    public $template_end   = '</div>';
    public $tag_name       = 'panel-body';

}
