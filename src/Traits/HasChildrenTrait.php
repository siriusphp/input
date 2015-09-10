<?php

namespace Sirius\Input\Traits;

use Sirius\Input\Element;
use Sirius\Input\Element\FactoryAwareInterface;
use Sirius\Input\Specs;

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
     * Generates the actual name that will be used to identify the element in the input object
     * For input objects the name of the child is the same as the name provided,
     * For field-sets the name of the child is prefixed/name-spaced with the name of the field-set
     * For collections the name of the child is prefixed with the name of the collection and an index placeholder
     *
     * @param string $name
     *
     * @return string
     */
    protected function getFullChildName($name)
    {
        return $name;
    }

    /**
     * Add an element to the children list
     *
     * @param string|\Sirius\Input\Element $nameOrElement
     * @param array $specs
     *
     * @throws \RuntimeException
     * @return $this
     */
    function addElement($nameOrElement, $specs = array())
    {
        if (is_string($nameOrElement)) {
            $name    = $nameOrElement;
            $element = $this->elementFactory->createFromOptions($this->getFullChildName($nameOrElement), $specs);
        } elseif ($nameOrElement instanceof Element) {
            $element = $nameOrElement;
            // for an element with the name 'address[street]' we get only the 'street'
            // because we assume the element has the name constructed using the rule in getFullChildName()
            $parts = explode('[', str_replace(']', '', $element->getName()));
            $name  = array_pop($parts);
        } else {
            throw new \RuntimeException(sprintf('Variable $nameorElement must be a string or an instance of the Element class'));
        }
        // add the index for sorting
        if ( ! isset($element['__index'])) {
            $element['__index'] = ($this->elementsIndex --);
        }
        $this->elements[$name] = $element;

        return $this;
    }

    /**
     *
     */
    protected function createChildren()
    {
        if ($this instanceof FactoryAwareInterface) {
            if (isset($this[Specs::CHILDREN])) {
                foreach ($this[Specs::CHILDREN] as $name => $options) {
                    $this->addElement($name, $options);
                }
            }
        }
    }

    /**
     * Retrieve an element by name
     *
     * @param string $name
     *
     * @return \Sirius\Input\Element
     */
    function getElement($name)
    {
        return isset($this->elements[$name]) ? $this->elements[$name] : null;
    }

    /**
     * Removes an element from the children list
     *
     * @param string $name
     *
     * @throws \RuntimeException
     * @return $this
     */
    function removeElement($name)
    {
        if (isset($this->elements[$name])) {
            unset($this->elements[$name]);
        }

        return $this;
    }

    /**
     * Returns whether an element exist in the children list
     *
     * @param string $name
     *
     * @return boolean
     */
    function hasElement($name)
    {
        return null !== $this->getElement($name);
    }

    /**
     * Input comparator callback
     *
     * @param \ArrayObject $childA
     * @param \ArrayObject $childB
     *
     * @return number
     */
    protected function childComparator($childA, $childB)
    {
        if ($childA->getPosition() < $childB->getPosition()) {
            return - 1;
        }
        if ($childA->getPosition() > $childB->getPosition()) {
            return 1;
        }
        if ($childA->get('__index') > $childB->get('__index')) {
            return - 1;
        }
        if ($childA->get('__index') < $childB->get('__index')) {
            return 1;
        }

        // if the priority is the same, childB is first
        return - 1;
    }

    /**
     * Returns the list of the elements organized by priority
     *
     * @return array
     */
    function getElements()
    {
        // first sort the children so they are retrieved by priority
        uasort($this->elements, array( $this, 'childComparator' ));

        return $this->elements;
    }


    /**
     * Unset the group property for elements without a valid group (ie: existing group)
     */
    protected function cleanUpMissingGroups()
    {
        foreach ($this->elements as $element) {
            $group = $element->getGroup();
            if ($group && ! isset($this->elements[$group])) {
                $element->setGroup(null);
            }
        }
    }

}
