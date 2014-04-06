<?php
namespace Sirius\Forms\Html;

/**
 * Base class for building HTML elements
 *
 * - attr(): set/get the element's attributes
 * - text(): set/get the element's innerHTML
 * - addClass(), removeClass(), toggleClass(): manipulate the element's classes
 * - data(): set/get miscelaneous data to the element
 */
class BaseTag
{

    protected $attrs = array();

    protected $data = array();

    protected $text;

    function __construct($attrs = array())
    {
        if ($attrs) {
            $this->setAttributes($attrs);
        }
    }

    function setAttributes($attrs)
    {
        foreach ($attrs as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    function setAttribute($name, $value = null)
    {
        if (is_string($name)) {
            if ($value === null && isset($this->attrs[$name])) {
                unset($this->attrs[$name]);
            } elseif ($value !== null) {
                $this->attrs[$name] = $value;
            }
        }
        return $this;
    }

    function getAttributes($list = null)
    {
        if ($list && is_array($list)) {
            $result = array();
            foreach ($list as $key) {
                $result[$key] = $this->getAttribute($key);
            }
            return $result;
        }
        return $this->attrs;
    }

    function getAttribute($name)
    {
        return isset($this->attrs[$name]) ? $this->attrs[$name] : null;
    }

    /**
     * Add a class to the element's class list
     *
     * @param string $class            
     * @return self
     */
    function addClass($class)
    {
        if (! $this->hasClass($class)) {
            $this->setAttribute('class', trim((string) $this->getAttribute('class') . ' ' . $class));
        }
        return $this;
    }

    /**
     * Remove a class from the element's class list
     *
     * @param string $class            
     * @return self
     */
    function removeClass($class)
    {
        $classes = $this->getAttribute('class');
        if ($classes) {
            $classes = preg_replace('/(^| ){1}' . $class . '( |$){1}/i', ' ', $classes);
            $this->setAttribute('class', $classes);
        }
        return $this;
    }

    /**
     * Toggles a class on the element
     *
     * @param string $class            
     * @return self
     */
    function toggleClass($class)
    {
        if ($this->hasClass($class)) {
            return $this->removeClass($class);
        }
        return $this->addClass($class);
    }

    /**
     * Checks if the element has a specific class
     *
     * @param string $class            
     * @return boolean
     */
    function hasClass($class)
    {
        $classes = $this->getAttribute('class');
        return $classes && ((bool) preg_match('/(^| ){1}' . $class . '( |$){1}/i', $classes));
    }

    function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    function getText()
    {
        return $this->text;
    }

    function getData($name = null)
    {
        if (is_string($name)) {
            if (isset($this->data[$name])) {
                return $this->data[$name];
            } else {
                return null;
            }
        } elseif (is_array($name)) {
            $data = array();
            foreach ($name as $k) {
                if (isset($this->data[$k])) {
                    $data[$k] = $this->data[$k];
                } else {
                    $data[$k] = null;
                }
            }
            return $data;
        }
        return $this->data;
    }

    function setData($name = null, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->data[$k] = $v;
            }
        } elseif (is_string($name)) {
            if ($value === null && isset($this->data[$name])) {
                unset($this->data[$name]);
            } elseif ($value !== null) {
                $this->data[$name] = $value;
            }
        }
        return $this;
    }

    /**
     * Return the attributes as a string for HTML output
     * example: title="Click here to delete" class="remove"
     *
     * @return string
     */
    protected function getAttributesString()
    {
        $result = array();
        $attrs = $this->getAttributes();
        ksort($attrs);
        foreach ($attrs as $k => $v) {
            if ($v !== true) {
                $result[] = $k . '="' . htmlspecialchars((string) $v, ENT_COMPAT) . '"';
            } else {
                $result[] = $k;
            }
        }
        $attrs = implode(' ', $result);
        if ($attrs) {
            $attrs = ' ' . $attrs;
        }
        return $attrs;
    }

    /**
     * Render the element
     *
     * @return string
     */
    function render()
    {
        if ($this->isSelfClosing) {
            $template = "<{$this->tag}%s>";
            $element = sprintf($template, $this->getAttributesString());
        } else {
            $template = "<{$this->tag}%s>%s</{$this->tag}>";
            $element = sprintf($template, $this->getAttributesString(), $this->getText());
        }
        return $element;
    }

    function __toString()
    {
        return $this->render();
    }
}