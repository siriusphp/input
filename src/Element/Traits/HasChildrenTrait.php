<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;

trait HasChildrenTrait
{
    /**
     * List of the child element
     *
     * @var array
     */
    protected $elements = array();

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
     * @param string $name
     * @param \Sirius\Forms\Element|array $specsOrElement
     * @throws \RuntimeException
     * @return Form
     */
    function add($name, $specsOrElement)
    {
        $name = $this->getFullChildName($name);
        $element = $specsOrElement;
        if (is_array($specsOrElement)) {
            $element = $this->elementFactory->createFromOptions($name, $specsOrElement);
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
        if ($childA->getPriority() < $childB->getPriority()) {
            return -1;
        }
        if ($childA->getPriority() > $childB->getPriority()) {
            return 1;
        }
        // if the priority is the same, childB is first
        return 1;
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
