<?php
/**
 * Bootstrap Wrapper Plugin: Tabs (nav alias)
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_tabs extends syntax_plugin_bootswrapper_nav
{

    public $pattern_start = '<tabs.*?>(?=.*?</tabs>)';
    public $pattern_end   = '</tabs>';
    public $nav_type      = 'tabs';
    public $tag_name      = 'tabs';

}
