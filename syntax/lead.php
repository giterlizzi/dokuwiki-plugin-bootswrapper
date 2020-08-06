<?php
/**
 * Bootstrap Wrapper Plugin: Lead
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_lead extends syntax_plugin_bootswrapper_bootstrap
{

    public $p_type         = 'block';
    public $pattern_start  = '<lead>';
    public $pattern_end    = '</lead>';
    public $template_start = '<div class="bs-wrap bs-wrap-lead lead">';
    public $template_end   = '</div>';
    public $tag_name       = 'lead';

}
