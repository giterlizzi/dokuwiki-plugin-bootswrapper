<?php
/**
 * Bootstrap Wrapper Plugin: List Group
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_list extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<list-group>';
    public $pattern_end    = '</list-group>';
    public $template_start = '<div class="bs-wrap bs-wrap-list-group hide">';
    public $template_end   = '</div>';
    public $tag_name       = 'list-group';

}
