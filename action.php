<?php
/**
 * Bootstrap Wrapper Action Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2020, Giuseppe Di Terlizzi
 */


/**
 * Bootstrap Wrapper Action Plugin
 *
 * Add external CSS file to DokuWiki
 */
class action_plugin_bootswrapper extends DokuWiki_Action_Plugin
{

    /**
     * Syntax with section edit
     *
     * @var array
     */
    private $section_edit_buttons = array(
        'plugin_bootswrapper_pane',
        'plugin_bootswrapper_panel',
    );

    /**
     * Register events
     *
     * @param  Doku_Event_Handler  $controller
     */
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, '_insert_button');
        $controller->register_hook('HTML_SECEDIT_BUTTON', 'BEFORE', $this, '_secedit_button');
        $controller->register_hook('HTML_EDIT_FORMSELECTION', 'BEFORE', $this, '_editform'); // deprecated
        $controller->register_hook('EDIT_FORM_ADDTEXTAREA', 'BEFORE', $this, '_editform'); // replacement
    }

    /**
     * Edit Form
     *
     * @param  Doku_Event  &$event
     */
    public function _editform(Doku_Event $event)
    {
        if (!in_array($event->data['target'], $this->section_edit_buttons)) {
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
    public function _secedit_button(Doku_Event $event)
    {
        global $lang;

        if (!in_array($event->data['target'], $this->section_edit_buttons)) {
            return;
        }

        $event->data['name'] = $lang['btn_secedit'] . ' - ' . ucfirst(str_replace('plugin_bootswrapper_', '', $event->data['target']));
    }

    /**
     * Set toolbar button in edit mode
     *
     * @param  Doku_Event  &$event
     */
    public function _insert_button(Doku_Event $event, $param)
    {
        $event->data[] = array(
            'type'    => 'mediapopup',
            'title'   => 'Bootstrap Wrapper',
            'icon'    => '../../plugins/bootswrapper/images/bootstrap.png',
            'url'     => 'lib/plugins/bootswrapper/exe/popup.php?ns=',
            'name'    => 'bootstrap-wrapper',
            'options' => 'width=800,height=600,left=20,top=20,toolbar=no,menubar=no,scrollbars=yes,resizable=yes',
            'block'   => false,
        );
    }
}
