<?php
/**
 * Bootstrap Wrapper: Popup helper
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2019, Giuseppe Di Terlizzi
 */

if (!defined('DOKU_INC')) define('DOKU_INC', dirname(__FILE__).'/../../../../');

define('DOKU_MEDIAMANAGER', 1); // needed to get proper CSS/JS

global $lang;
global $INPUT;
global $ACT;
global $INFO;

require_once(DOKU_INC.'inc/init.php');

if ($conf['template'] == 'bootstrap3') {

  include_once(DOKU_INC.'lib/tpl/bootstrap3/tpl_functions.php');
  include_once(DOKU_INC.'lib/tpl/bootstrap3/tpl_global.php');

}

session_write_close();  //close session

$syntax = $INPUT->get->str('syntax');

if ($syntax) {

  $help_file = dirname(__FILE__) . '/help/' . $syntax . '.txt';

  if (file_exists($help_file)) {

    $INFO['exists'] = true;
    $ACT = 'show';

    $help_content = file_get_contents($help_file);

    echo bootstrap3_content(p_render('xhtml', p_get_instructions($help_content), $info));

  }

}
