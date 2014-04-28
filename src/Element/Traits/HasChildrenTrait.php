<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;
use Sirius\Forms\Element;

trait HasChildrenTrait
{
    /**
     * List of the child element
     *
     * @var array
     */
    protected $elements = array();

    /**
     * Value to keep track of the order the elements were added
     *
     * @var int
     */
    protected $elementsIndex = PHP_INT_MAX;

    /**
     * Generates the actual name that will be used to identify the element in the form
     * For forms the name of the child is the same as the name provided,
     * For field-sets the name of the child is prefixed/name-spaced with the name of the field-set
     * For collections the name of the child is prefixed with the name of the collection and an index placeholder
     *
     * @param string $name
     * @return string
     */
    protected function getFullChildName($name)
    {
        return $name;
    }

    /**
     * Add an element to the children list
     *
     * @param string|\Sirius\Forms\Element $nameOrElement
     * @param array $specs
     * @throws \RuntimeException
     * @return $this
     */
    function add($nameOrElement, $specs = array())
    {
        if (is_string($nameOrElement)) {
            $name = $this->getFullChildName($nameOrElement);
            $element = $this->elementFactory->createFromOptions($name, $specs);
        } elseif ($nameOrElement instanceof Element) {
            $element = $nameOrElement;
            $name = $element->getName();
        } else {
            throw new \RuntimeException(sprintf('Variable $nameorElement must be a string or an instance of the Element class'));
        }
        // add the index for sorting
        if (!isset($element['__index'])) {
            $element['__index'] = ($this->elementsIndex--);
        }
        $this->elements[$name] = $element;
        return $this;
    }

    /**
     * Retrieve an element by name
     *
     * @param string $name
     * @return \Sirius\Forms\Element
     */
    function get($name)
    {
        $name = $this->getFullChildName($name);
        return isset($this->elements[$name]) ? $this->elements[$name] : null;
    }

    /**
     * Removes an element from the children list
     *
     * @param string $name
     * @throws \RuntimeException
     * @return Form
     */
    function remove($name)
    {
        $name = $this->getFullChildName($name);
        if (isset($this->elements[$name])) {
            unset($this->elements[$name]);
        }
        return $this;
    }

    /**
     * Returns whether an element exist in the children list
     *
     * @param string $name
     * @return boolean
     */
    function has($name)
    {
        return null !== $this->get($name);
    }

    /**
     * Input comparator callback
     *
     * @param \ArrayObject $childA
     * @param \ArrayObject $childB
     * @return number
     */
    protected function childComparator($childA, $childB)
    {
        if ($childA->getPosition() < $childB->getPosition()) {
            return -1;
        }
        if ($childA->getPosition() > $childB->getPosition()) {
            return 1;
        }
        if ($childA->get('__index') > $childB->get('__index')) {
            return -1;
        }
        if ($childA->get('__index') < $childB->get('__index')) {
            return 1;
        }
        // if the priority is the same, childB is first
        return -1;
    }

    /**
     * Returns the list of the elements organized by priority
     *
     * @return array
     */
    function getChildren()
    {
        // first sort the children so they are retrieved by priority
        uasort($this->elements, array($this, 'childComparator'));
        return $this->elements;
    }

}
