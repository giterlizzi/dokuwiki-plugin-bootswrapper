<?php
/**
 * Bootstrap Wrapper Plugin: Badge
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_badge extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'normal';
    public $pattern_start  = '<badge>';
    public $pattern_end    = '</badge>';
    public $template_start = '<span class="bs-wrap bs-wrap-badge badge">';
    public $template_end   = '</span>';
    public $tag_name       = 'badge';

}
