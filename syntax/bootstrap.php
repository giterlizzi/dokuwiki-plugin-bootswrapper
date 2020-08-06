<?php
/**
 * Bootstrap Wrapper Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2015-2019, Giuseppe Di Terlizzi
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) {
    die();
}

if (!defined('DOKU_PLUGIN')) {
    define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
}

class syntax_plugin_bootswrapper_bootstrap extends DokuWiki_Syntax_Plugin
{

    public $p_type           = 'stack';
    public $pattern_start    = '<BOOTSTRAP.+?>';
    public $pattern_end      = '</BOOTSTRAP>';
    public $template_start   = '<div class="%s">';
    public $template_content = '%s';
    public $template_end     = '</div>';
    public $header_pattern   = '[ \t]*={2,}[^\n]+={2,}[ \t]*(?=\n)';
    public $tag_attributes   = array();
    public $tag_name         = null;

    // HTML core/global attribute
    public $core_attributes = array(
        'id'    => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),
        'class' => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),
        'style' => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),
        'title' => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),
        'lang'  => array(
            'type'     => 'string',
            'values'   => null,
            'required' => false,
            'default'  => null),
        'dir'   => array(
            'type'     => 'string',
            'values'   => array('ltr', 'rtl'),
            'required' => false,
            'default'  => null),
    );

    /**
     * Check default and user attributes
     *
     * @param   array  $attributes
     */
    protected function checkAttributes($attributes = array())
    {

        global $ACT;

        $default_attributes = array();
        $merged_attributes  = array();
        $checked_attributes = array();

        if ($ACT == 'preview') {
            $msg_title = '<strong>Bootstrap Wrapper Plugin - ' . (ucfirst(str_replace('syntax_plugin_bootswrapper_',
                '', get_class($this)))) . '</strong>';
        }

        $tag_attributes = array_merge($this->core_attributes, $this->tag_attributes);

        // Save the default values of attributes
        foreach ($tag_attributes as $attribute => $item) {
            $default_attributes[$attribute] = $item['default'];
        }

        foreach ($attributes as $name => $value) {

            if (!isset($tag_attributes[$name])) {
                if ($ACT == 'preview') {
                    msg("$msg_title Unknown attribute <code>$name</code>", -1);
                }
                continue;
            }

            $item = $tag_attributes[$name];

            $required = isset($item['required']) ? $item['required'] : false;
            $values   = isset($item['values']) ? $item['values'] : null;
            $default  = isset($item['default']) ? $item['default'] : null;

            // Normalize boolean value
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

            if ($name == 'class') {
                $value = explode(' ', $value);
            }

            $checked_attributes[$name] = $value;

            // Set the default value when the user-value is empty
            if ($required && empty($value)) {
                $checked_attributes[$name] = $default;

                // Check if the user attribute have a valid range values (single value)
            } elseif ($item['type'] !== 'multiple' && is_array($values) && !in_array($value, $values)) {
                if ($ACT == 'preview') {
                    msg("$msg_title Invalid value (<code>$value</code>) for <code>$name</code> attribute. It will apply the default value <code>$default</code>", 2);
                }

                $checked_attributes[$name] = $default;

                // Check if the user attribute have a valid range values (multiple values)
            } elseif ($item['type'] == 'multiple') {

                $multitple_values = explode(' ', $value);
                $check            = 0;

                foreach ($multitple_values as $single_value) {
                    if (!in_array($single_value, $values)) {
                        $check = 1;
                    }
                }

                if ($check) {
                    if ($ACT == 'preview') {
                        msg("$msg_title Invalid value (<code>$value</code>) for <code>$name</code> attribute. It will apply the default value <code>$default</code>", 2);
                    }
                    $checked_attributes[$name] = $default;
                }
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
        // msg("$msg_title " . print_r($merged_attributes, 1));

        return $merged_attributes;

    }

    public function getType()
    {
        return 'formatting';
    }

    public function getAllowedTypes()
    {
        return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs');
    }

    public function getPType()
    {
        return $this->p_type;
    }

    public function getSort()
    {
        return 195;
    }

    public function connectTo($mode)
    {
        $this->Lexer->addEntryPattern($this->pattern_start, $mode, 'plugin_bootswrapper_' . $this->getPluginComponent());
    }

    public function postConnect()
    {
        $this->Lexer->addExitPattern($this->pattern_end, 'plugin_bootswrapper_' . $this->getPluginComponent());
        $this->Lexer->addPattern($this->header_pattern, 'plugin_bootswrapper_' . $this->getPluginComponent());
    }

    public function handle($match, $state, $pos, Doku_Handler $handler)
    {

        switch ($state) {
            case DOKU_LEXER_MATCHED:
                $title = trim($match);
                $level = 7 - strspn($title, '=');
                if ($level < 1) {
                    $level = 1;
                }

                $title = trim($title, '=');
                $title = trim($title);

                $handler->_addCall('header', array($title, $level, $pos), $pos);

                break;

            case DOKU_LEXER_ENTER:
                $attributes = array();
                $xml        = simplexml_load_string(str_replace('>', '/>', $match));

                if (!is_object($xml)) {
                    $xml = simplexml_load_string('<foo />');

                    global $ACT;

                    if ($ACT == 'preview') {
                        msg('<strong>Bootstrap Wrapper</strong> - Malformed tag (<code>' . hsc($match) . '</code>). Please check your code!', -1);
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

                return array($state, $match, $pos, $checked_attributes, $is_block);

            case DOKU_LEXER_UNMATCHED:
                $handler->_addCall('cdata', array($match), $pos, null);
                break;

            case DOKU_LEXER_EXIT:
                return array($state, $match, $pos, null);
        }

        return array();
    }

    public function render($mode, Doku_Renderer $renderer, $data)
    {

        if (empty($data)) {
            return false;
        }

        if ($mode !== 'xhtml') {
            return false;
        }

        /** @var Doku_Renderer_xhtml $renderer */
        list($state, $match) = $data;

        if ($state == DOKU_LEXER_ENTER) {
            $markup = $this->template_start;
            $renderer->doc .= $markup;
            return true;
        }

        if ($state == DOKU_LEXER_EXIT) {
            $renderer->doc .= $this->template_end;
            return true;
        }

        return true;
    }

    protected function mergeCoreAttributes($attributes)
    {

        $core_attributes = array();

        foreach (array_keys($this->core_attributes) as $attribute) {
            if (isset($attributes[$attribute])) {
                $core_attributes[$attribute] = $attributes[$attribute];
            }
        }

        return $core_attributes;
    }

    protected function buildAttributes($attributes, $override_attributes = array())
    {

        $attributes      = array_merge_recursive($attributes, $override_attributes);
        $html_attributes = array();

        foreach ($attributes as $attribute => $value) {
            if ($attribute == 'class') {
                $value = trim(implode(' ', array_unique($value)));
            }

            if ($attribute == 'style') {
                $tmp = '';
                foreach ($value as $property => $val) {
                    $tmp .= "$property:$val";
                }
                $value = $tmp;
            }

            if ($value) {
                $html_attributes[] = "$attribute=\"$value\"";
            }
        }

        return implode(' ', $html_attributes);

    }

}
