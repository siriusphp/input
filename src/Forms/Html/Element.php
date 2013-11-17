<?php
namespace Sirius\Forms\Html;

/**
 * Base class for building form elements
 * 
 * - attr(): set/get the element's attributes
 * - text(): set/get the element's innerHTML
 * - addClass(), removeClass(), toggleClass(): manipulate the element's classes
 * - data(): set/get miscelaneous data to the element
 */
class Element
{

    protected $attrs = array();

    protected $data = array();

    protected $text;

    function __construct($attrs = array())
    {
        if ($attrs) {
            $this->setAttr($attrs);
        }
    }

    /**
     * Get/Set an attribute on the element
     * 
     * @example
     * $element->attr();                  // get all attributes
     * $element->attr(array('name', 'class')); //get some attributes
     * $element->attr('class');           // get the 'class' attribute
     * $element->attr('class', 'active'); // set the 'class' attribute
     * $element->attr($associativeArray); // set a bunch of attributes at once
     * $element->attr('class', null);     // remove the 'class' attribute
     * 
     * @param string $name
     * @param string $value
     * @throws \IntvalidArgumentException
     * @return self|mixed
     */
    function attr($name = null, $value = null)
    {
        if (count(func_get_args()) == 0 || $name === null) {
            return $this->getAttr();
        }
        if (is_array($name)) {
            if (range(0, count($name) - 1) == array_keys($name)) {
                return $this->getAttr($name);
            } else {
                return $this->setAttr($name);
            }
        }
        if (is_string($name)) {
            if (count(func_get_args()) == 1) {
                return $this->getAttr($name);
            } else {
                return $this->setAttr($name, $value);
            }
        }
        throw new \InvalidArgumentException('The attr() method did not receive the proper arguments');
    }

    protected function setAttr($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->attrs[$k] = $v;
            }
        } elseif (is_string($name)) {
            if ($value === null && isset($this->attrs[$name])) {
                unset($this->attrs[$name]);
            } elseif ($value !== null) {
                $this->attrs[$name] = $value;
            }
        }
        return $this;
    }

    protected function getAttr($name = null)
    {
        if (count(func_get_args()) === 0 || $name === null) {
            return $this->attrs;
        }
        if (is_array($name)) {
            $result = array();
            foreach ($name as $key) {
                $result[$key] = $this->getAttr($key);
            }
            return $result;
        }
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
            $this->attr('class', trim((string) $this->attr('class') . ' ' . $class));
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
        $classes = $this->attr('class');
        if ($classes) {
            $classes = preg_replace('/(^| ){1}' . $class . '( |$){1}/i', ' ', $classes);
            $this->attr('class', $classes);
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
        $classes = $this->getAttr('class');
        return $classes && ((bool) preg_match('/(^| ){1}' . $class . '( |$){1}/i', $classes));
    }

    /**
     * Get/Set the innerHTML of the element
     * 
     * @param string $text
     */
    function text($text = null)
    {
        if (count(func_get_args()) === 0) {
            return $this->getText();
        }
        return $this->setText($text);
    }

    protected function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    protected function getText()
    {
        return $this->text;
    }

    /**
     * Set/Get data attached to this element
     * 
     * @param string|array $name            
     * @param mixed $value            
     * @return array mixed
     */
    function data($name = null, $value = null)
    {
        if (count(func_get_args()) == 0 || $name === null) {
            return $this->getData();
        }
        if (is_array($name)) {
            if (range(0, count($name) - 1) == array_keys($name)) {
                return $this->getData($name);
            } else {
                return $this->setData($name);
            }
        }
        if (is_string($name)) {
            if (count(func_get_args()) == 1) {
                return $this->getData($name);
            } else {
                return $this->setData($name, $value);
            }
        }
        throw new \InvalidArgumentException('The data() method did not receive the proper arguments');
    }

    protected function getData($name = null)
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

    protected function setData($name = null, $value = null)
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
}