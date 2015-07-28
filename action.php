<?php
/**
 * Bootstrap Wrapper Action Plugin
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015, Giuseppe Di Terlizzi
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
     * Register events
     *
     * @param  Doku_Event_Handler  $controller
     */
    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_load');
    }


    /**
     * Event handler
     *
     * @param  Doku_Event  &$event
     */
    public function _load(Doku_Event &$event, $param) {

        if ($this->getConf('loadBootstrap')) {

            $event->data['link'][] = array(
              'type' => 'text/css',
              'rel'  => 'stylesheet',
              'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
            );

            $event->data['link'][] = array(
              'type' => 'text/css',
              'rel'  => 'stylesheet',
              'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css',
            );

            $event->data['script'][] = array(
              'type' => 'text/javascript',
              'src'  => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'
            );

        }

    }

}
