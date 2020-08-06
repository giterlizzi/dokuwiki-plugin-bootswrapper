<?php
/**
 * Bootstrap Wrapper Plugin: Row (grid alias)
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

class syntax_plugin_bootswrapper_row extends syntax_plugin_bootswrapper_grid
{

    public $pattern_start = '<row>';
    public $pattern_end   = '</row>';
    public $tag_name      = 'row';

}
