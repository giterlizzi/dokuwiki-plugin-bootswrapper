<?php
/**
 * Bootstrap Wrapper: Popup helper
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

$doku_inc_dirs = array(
    '/opt/bitnami/dokuwiki', # Bitnami (Docker)
    '/usr/share/webapps/dokuwiki', # Arch Linux
    '/usr/share/dokuwiki', # Debian/Ubuntu
    '/app/dokuwiki', # LinuxServer.io (Docker),
    realpath(dirname(__FILE__) . '/../../../../'), # Default DokuWiki path
);

# Load doku_inc.php file
#
if (file_exists(dirname(__FILE__) . '/../doku_inc.php')) {
    require_once dirname(__FILE__) . '/../doku_inc.php';
}

if (!defined('DOKU_INC')) {
    foreach ($doku_inc_dirs as $dir) {
        if (!defined('DOKU_INC') && @file_exists("$dir/inc/init.php")) {
            define('DOKU_INC', "$dir/");
        }
    }
}

if (!file_exists(DOKU_INC)) {
    print 'Problem with DOKU_INC directory. Please check your DokuWiki installation directory!';
    die;
}

define('DOKU_MEDIAMANAGER', 1); // needed to get proper CSS/JS

global $lang;
global $INPUT;
global $ACT;
global $INFO;

require_once DOKU_INC . 'inc/init.php';

session_write_close(); //close session

$syntax = $INPUT->get->str('syntax');

if ($syntax) {

    $help_file = dirname(__FILE__) . '/help/' . $syntax . '.txt';

    if (file_exists($help_file)) {

        $INFO['exists'] = true;
        $ACT            = 'show';

        $help_content = file_get_contents($help_file);

        echo str_replace(array('class="inline"'), array('class="inline table"'), p_render('xhtml', p_get_instructions($help_content), $info));

    }

}
