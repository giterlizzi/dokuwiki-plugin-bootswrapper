<?php
/**
 * Bootstrap Wrapper Action Plugin
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2018, Giuseppe Di Terlizzi
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

/**
 * Bootstrap Wrapper Action Plugin
 *
 * Add external CSS file to DokuWiki
 */
class action_plugin_bootswrapper extends DokuWiki_Action_Plugin {


  /**
   * Syntax with section edit
   *
   * @var array
   */
  private $section_edit_buttons = array(
    'plugin_bootswrapper_pane',
    'plugin_bootswrapper_panel'
  );


  /**
    * Register events
    *
    * @param  Doku_Event_Handler  $controller
    */
  public function register(Doku_Event_Handler $controller) {
    $controller->register_hook('TPL_METAHEADER_OUTPUT',   'BEFORE', $this, '_load');
    $controller->register_hook('TOOLBAR_DEFINE',          'AFTER',  $this, '_insert_button');
    $controller->register_hook('HTML_SECEDIT_BUTTON',     'BEFORE', $this, '_secedit_button');
    $controller->register_hook('HTML_EDIT_FORMSELECTION', 'BEFORE', $this, '_editform');
  }


  /**
    * Edit Form
    *
    * @param  Doku_Event  &$event
    */
  function _editform(Doku_Event $event) {

    if (! in_array($event->data['target'], $this->section_edit_buttons)) {
      return;
    }

    $event->data['target'] = 'section';
    return;

  }


  /**
    * Set Section Edit button
    *
    * @param  Doku_Event  &$event
    */
  function _secedit_button(Doku_Event $event) {

    global $lang;

    if (! in_array($event->data['target'], $this->section_edit_buttons)) {
      return;
    }

    $event->data['name'] = $lang['btn_secedit'] . ' - ' . ucfirst(str_replace('plugin_bootswrapper_', '', $event->data['target']));

  }


  /**
    * Load Bootstrap CSS
    *
    * @param  Doku_Event  &$event
    */
  public function _load(Doku_Event $event) {

    global $conf;

    if ($this->getConf('loadBootstrap') && $conf['template'] !== 'bootstrap3') {

      $event->data['link'][] = array(
        'type' => 'text/css',
        'rel'  => 'stylesheet',
        'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
      );

      $event->data['link'][] = array(
        'type' => 'text/css',
        'rel'  => 'stylesheet',
        'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css',
      );

      $event->data['script'][] = array(
        'type' => 'text/javascript',
        'src'  => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'
      );

    }

  }


  /**
    * Set toolbar button in edit mode
    *
    * @param  Doku_Event  &$event
    */
  public function _insert_button(Doku_Event $event, $param) {

    $event->data[] = array(
      'type'   => 'mediapopup',
      'title'  => 'Bootstrap Wrapper',
      'icon'   => '../../plugins/bootswrapper/images/bootstrap.png',
      'url'    => 'lib/plugins/bootswrapper/exe/popup.php?ns=',
      'name'   => 'bootstrap-wrapper',
      'options'=> 'width=800,height=600,left=20,top=20,toolbar=no,menubar=no,scrollbars=yes,resizable=yes',
      'block'  => false
    );

  }

}
