<?php
/**
 * Bootstrap Wrapper Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2016, Giuseppe Di Terlizzi
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

class syntax_plugin_bootswrapper_bootstrap extends DokuWiki_Syntax_Plugin {

  protected $pattern_start    = '<BOOTSTRAP.+?>';
  protected $pattern_end      = '</BOOTSTRAP>';
  protected $template_content = '%s';
  protected $template_end     = '</div>';
  protected $header_pattern   = '[ \t]*={2,}[^\n]+={2,}[ \t]*(?=\n)';
  protected $tag_attributes   = array();
  protected $styling_attributes = array(

    'style' => array('type'  => 'string',
                  'values'   => null,
                  'required' => false,
                  'default'  => ''),

    'class' => array('type'  => 'string',
                  'values'   => null,
                  'required' => false,
                  'default'  => ''),

    'id' => array('type'     => 'integer',
                  'values'   => null,
                  'required' => false,
                  'default'  => '')

  );

  /**
    * Check default and user attributes
    *
    * @param   array  $attributes
    */
  function checkAttributes($attributes = array()) {

    global $ACT;

    if ($this->getConf('allowStylingAttributes')) {
      $all_attributes  = array_merge($this->tag_attributes, $this->styling_attributes);
    } else {
      $all_attributes  = $this->tag_attributes;
    }

    $default_attributes = array();
    $merged_attributes  = array();
    $checked_attributes = array();

    if ($ACT == 'preview') {
      $msg_title = sprintf('<strong>Bootstrap Wrapper - %s</strong>',
                            ucfirst(str_replace('syntax_plugin_bootswrapper_',
                                                '', get_class($this))));
    }

    // Save the default values of attributes
    foreach ($all_attributes as $attribute => $item) {
      $default_attributes[$attribute] = $item['default'];
    }

    foreach ($attributes as $name => $value) {

      if (! isset($all_attributes[$name])) {

        if ($ACT == 'preview') {
          msg(sprintf('%s Unknown attribute <code>%s</code>', $msg_title, $name), -1);
        }

        continue;

      }

      $item = $all_attributes[$name];

      $required = isset($item['required']) ? $item['required'] : false;
      $values   = isset($item['values'])   ? $item['values']   : null;
      $default  = isset($item['default'])  ? $item['default']  : null;

      if ($item['type'] == 'boolean') {
        switch ($value) {
          case 'false':
          case 'FALSE':
            $value = false;
            break;
          case 'true':
          case 'TRUE':
            $value = true;
            break;
        }
      }

      $checked_attributes[$name] = $value;

      // Set the default value when the user-value is empty
      if ($required && empty($value)) {
        $checked_attributes[$name] = $default;

      // Check if the user attribute have a valid range values
      } elseif (is_array($values) && ! in_array($value, $values)) {

        if ($ACT == 'preview') {
          msg(sprintf('%s Invalid value (<code>%s</code>) for <code>%s</code> attribute. It will apply the default value <code>%s</code>',
                      $msg_title, $value, $name, $default), 2);
        }

        $checked_attributes[$name] = $default;
      }

    }

    // Merge attributes (default + user)
    $merged_attributes = array_merge($default_attributes, $checked_attributes);

    // Remove empty attributes
    foreach ($merged_attributes as $attribute => $value) {
      if (empty($value)) {
        unset($merged_attributes[$attribute]);
      }
    }

    // Uncomment for debug
    //msg(sprintf('%s %s', $msg_title, print_r($merged_attributes, 1)));

    return $merged_attributes;

  }

  /**
   * Get array with styling attributes from the attributes array passed in.
   * If the user has styling disabled this array will contain empty strings.
   * @param array $attributes The attribute array with user values.
   * @return array The array with styling attribute values or empty string.
   */
  function getStylingAttributes($attributes) {
    $styling = array(
      'class' => '',
      'id' => '',
      'style' => ''
    );

    if ($this->getConf('allowStylingAttributes')) {
      if (isset($attributes['class']) && $attributes['class'])
        $styling['class'] = $attributes['class'];
      if (isset($attributes['id']) && $attributes['id'])
        $styling['id'] = $attributes['id'];
      if (isset($attributes['style']) && $attributes['style'])
        $styling['style'] = $attributes['style'];
    }

    return $styling;
  }


  function getType(){ return 'formatting'; }
  function getAllowedTypes() { return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs'); }
  function getPType(){ return 'stack'; }
  function getSort(){ return 195; }


  function connectTo($mode) {
    $this->Lexer->addEntryPattern($this->pattern_start, $mode, 'plugin_bootswrapper_'.$this->getPluginComponent());
  }


  public function postConnect() {
    $this->Lexer->addExitPattern($this->pattern_end, 'plugin_bootswrapper_'.$this->getPluginComponent());
    $this->Lexer->addPattern($this->header_pattern, 'plugin_bootswrapper_'.$this->getPluginComponent());
  }


  function handle($match, $state, $pos, Doku_Handler $handler) {

    switch ($state) {

      case DOKU_LEXER_MATCHED:

        $title = trim($match);
        $level = 7 - strspn($title,'=');
        if($level < 1) $level = 1;
        $title = trim($title,'=');
        $title = trim($title);

        $handler->_addCall('header',array($title,$level,$pos), $pos);

        break;

      case DOKU_LEXER_ENTER:

        $attributes = array();
        $xml        = simplexml_load_string(str_replace('>', '/>', $match));

        if (! is_object($xml)) {

          $xml = simplexml_load_string('<foo />');

          global $ACT;

          if ($ACT == 'preview') {
            msg(sprintf('<strong>Bootstrap Wrapper</strong> - Malformed tag (<code>%s</code>). Please check your code!', hsc($match)), -1);
          }

        }

        $tag = $xml->getName();

        foreach ($xml->attributes() as $key => $value) {
          $attributes[$key] = (string) $value;
        }

        if ($tag == strtolower($tag)) {
          $is_block = false;
        }

        if ($tag == strtoupper($tag)) {
          $is_block = true;
        }

        $checked_attributes = $this->checkAttributes($attributes);

        return array($state, $match, $checked_attributes, $is_block);

      case DOKU_LEXER_UNMATCHED:
        $handler->_addCall('cdata', array($match), $pos, null);
        break;

      case DOKU_LEXER_EXIT:
        return array($state, '', $pos, null);

    }

    return array();

  }


  function render($mode, Doku_Renderer $renderer, $data) {

    if (empty($data)) return false;
    if ($mode !== 'xhtml') return false;

    /** @var Doku_Renderer_xhtml $renderer */
    list($state, $match, $attributes) = $data;

    switch($state) {

      case DOKU_LEXER_ENTER:
        $style = $this->getStylingAttributes($attributes);

        $markup = sprintf($this->template_start, $style['class'], $style['id'], $style['style']);
        $renderer->doc .= $markup;
        return true;

      case DOKU_LEXER_EXIT:
        $renderer->doc .= $this->template_end;
        return true;

    }

    return true;

  }

}
