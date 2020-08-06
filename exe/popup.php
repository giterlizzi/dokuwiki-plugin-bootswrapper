<?php
/**
 * Bootstrap Wrapper: Popup helper
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */

$doku_inc_dirs = array(
    '/opt/bitnami/dokuwiki',                       # Bitnami (Docker)
    '/usr/share/webapps/dokuwiki',                 # Arch Linux
    '/usr/share/dokuwiki',                         # Debian/Ubuntu
    '/app/dokuwiki',                               # LinuxServer.io (Docker),
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

require_once DOKU_INC . 'inc/init.php';
require_once DOKU_INC . 'inc/template.php';
require_once DOKU_INC . 'inc/lang/en/lang.php';
require_once DOKU_INC . 'inc/lang/' . $conf['lang'] . '/lang.php';

global $lang;
global $conf;
global $JSINFO;
global $INPUT;

$JSINFO['id']        = '';
$JSINFO['namespace'] = '';

$NS = cleanID($INPUT->str('ns'));

$tmp = array();
trigger_event('MEDIAMANAGER_STARTED', $tmp);
session_write_close(); //close session

$syntax = array();

foreach (scandir(dirname(__FILE__) . '/../syntax/') as $file) {

    if ($file == '.' || $file == '..') {
        continue;
    }

    $file              = str_replace('.php', '', $file);
    $syntax_class_name = "syntax_plugin_bootswrapper_$file";
    $syntax_class      = new $syntax_class_name;

    if ($file == 'macros') {
        continue;
    }

    if ($tag_name = $syntax_class->tag_name) {
        $tag_attributes = $syntax_class->tag_attributes;
        if ($tag_name == 'pills' || $tag_name == 'tabs') {
            unset($tag_attributes['type']);
        }
        $syntax[$tag_name] = $tag_attributes;
    }

}

ksort($syntax);

header('Content-Type: text/html; charset=utf-8');
header('X-UA-Compatible: IE=edge,chrome=1');

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>" lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Bootstrap Wrapper Plugin</title>
  <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <?php
        if (tpl_getConf('themeByNamespace')) {
            echo '<link href="' . tpl_basedir() . 'css.php?id='. cleanID("$NS:start") .'" rel="stylesheet" />';
        }
  ?>
  <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
  <?php tpl_metaheaders()?>
  <!--[if lt IE 9]>
  <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript" src="popup.js" <?php echo ((isset($conf['defer_js']) && $conf['defer_js']) ? 'defer="defer"' : '') ?>></script>
  <style>
    body { padding-top: 10px; }
    footer { padding-top: 100px; }
    aside .nav li { margin: 0; }
    aside .nav li a { padding: 1px 5px !important; }
    pre#preview { white-space: pre-wrap; }
  </style>
</head>
<body class="container-fluid dokuwiki">

  <div class="row">
    <aside class="small col-xs-2">
      <ul class="nav nav-pills nav-stacked" role="tablist">

        <?php foreach (array_keys($syntax) as $tag): ?>
        <li>
          <a data-toggle="tab" href="#tab-<?php echo $tag ?>" data-component="<?php echo $tag ?>"><?php echo ucfirst($tag) ?></a>
        </li>
        <?php endforeach?>

      </ul>
    </aside>

    <main class="col-xs-10 tab-content">

      <?php foreach ($syntax as $tag => $item): ?>
      <div id="tab-<?php echo $tag ?>" class="tab-pane fade">

        <?php if (file_exists(dirname(__FILE__) . '/help/' . $tag . '.txt')): ?>
        <div class="text-right">
          <button title="Help <?php echo $tag ?>" type="button" data-help="help.php?syntax=<?php echo $tag ?>" data-toggle="modal" data-target="#help-modal" class="btn btn-xs btn-primary help-btn">
            <i class="fa fa-question-circle"></i>
        </button>
        </div>
        <?php endif;?>

        <h3><?php echo ucfirst($tag) ?></h3>
        <p>&nbsp;</p>

        <form class="form-horizontal">
          <?php foreach ($item as $type => $data): ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $type ?></label>
              <div class="col-sm-10 attribute" data-attribute-type="<?php echo $data['type'] ?>" data-attribute-name="<?php echo $type ?>">
                <?php
                    switch ($data['type']) {

                        case 'string':
                            if (is_array($data['values'])) {
                                echo '<select class="form-control">';
                                echo '<option></option>';
                                foreach ($data['values'] as $value) {
                                    echo '<option ' . (($data['default'] == $value) ? 'selected="selected"' : '') . ' value="' . $value . '" class="text-' . $value . '">' . $value . '</option>';
                                }
                                echo '</select>';
                            } else {
                                echo '<input type="text" class="form-control" />';
                            }
                            break;

                        case 'boolean':
                            echo '<input type="checkbox" class="checkbox-inline" />';
                            break;

                        case 'integer':
                            echo '<input type="number" min="' . @$data['min'] . '" max="' . @$data['max'] . '" value="' . $data['default'] . '" class="form-control" />';
                            break;
                    }
                ?>
              </div>
            </div>
          <?php endforeach;?>
        </form>

      </div>
      <?php endforeach;?>

      <div class="preview-box hide">

        <h5>Preview</h5>

        <pre id="preview"></pre>

        <input type="hidden" id="output" />
        <input type="hidden" id="component" />

      </div>

    </main>

  </div>

  <footer>
    <nav class="navbar navbar-default navbar-fixed-bottom">
      <div class="container-fluid">
        <div class="navbar-text">
          <button type="button" id="btn-preview" class="hidden btn btn-default">Preview code</button>
          <button type="button" id="btn-insert" class="btn btn-success">Insert</button>
          <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
        </div>
      </div>
    </nav>
  </footer>

  <div class="modal fade" tabindex="-1" role="dialog" id="help-modal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-question-circle"></i> Help</h4>
        </div>
        <div class="modal-body px-5"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-primary" data-dismiss="modal">
            <i class="fa fa-times"></i> Close
          </button>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
