<?php

namespace Sirius\Input\Traits;

use Sirius\Input\Element;
use Sirius\Input\Element\Factory as ElementFactory;
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
     * @var ElementFactory
     */
    protected $elementFactory;

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
     * Sets the element factory.
     * Objects that have children (eg: Fieldset, Collection) must be factory-aware
     * This is passed down from form to fieldsets, collections or other elements that have children
     *
     * @param ElementFactory $elementFactory
     * @return $this
     */
    public function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;
        $this->createChildren();

        return $this;
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
    public function addElement($nameOrElement, $specs = array())
    {
        if (is_string($nameOrElement)) {

            $name = $nameOrElement;
            $element = $this->elementFactory->createFromOptions($this->getFullChildName($nameOrElement), $specs);

        } elseif ($nameOrElement instanceof Element) {

            $element = $nameOrElement;
            // for an element with the name 'address[street]' we get only the 'street'
            // because we assume the element has the name constructed using the rule in getFullChildName()
            $parts = explode('[', str_replace(']', '', $element->getName()));
            $name = array_pop($parts);

        } else {

            throw new \RuntimeException(sprintf('Variable $nameorElement must be a string or an instance of the Element class'));

        }

        $this->ensureGroupExists($element);

        // add the index for sorting
        if (!isset($element['__index'])) {

            $element['__index'] = ($this->elementsIndex--);

        }

        $this->elements[$name] = $element;

        return $this;
    }

    /**
     * Make sure a Group type element is added to the children if the element has a group
     *
     * @param Element $element
     */
    protected function ensureGroupExists(Element $element) {

        if (!$element->getGroup() || $this->hasElement($element->getGroup())) {
            return;
        }

        $this->addElement($element->getGroup(), array(
            Specs::TYPE => 'group',
            Specs::POSITION => $element->getPosition()
        ));
    }

    /**
     * Create the children using the factory.
     * This will be called by elements that are factory-aware (eg: Fieldsets)
     */
    protected function createChildren()
    {
        /* @var $this \ArrayObject */
        if (isset($this[Specs::CHILDREN])) {
            foreach ($this[Specs::CHILDREN] as $name => $options) {
                $this->addElement($name, $options);
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
    public function getElement($name)
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
    public function removeElement($name)
    {
        if (array_key_exists($name, $this->elements)) {
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
    public function hasElement($name)
    {
        return null !== $this->getElement($name);
    }

    /**
     * Input comparator callback
     *
     * @param \ArrayObject $childA
     * @param \ArrayObject $childB
     *
     * @return integer
     */
    protected function childComparator($childA, $childB)
    {
        $posA = isset($childA[Specs::POSITION]) ? $childA[Specs::POSITION] : 0;
        $posB = isset($childB[Specs::POSITION]) ? $childB[Specs::POSITION] : 0;

        if ($posA < $posB) {
            return -1;
        }
        if ($posA > $posB) {
            return 1;
        }

        if ($childA['__index'] > $childB['__index']) {
            return -1;
        }
        if ($childA['__index'] < $childB['__index']) {
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
    public function getElements()
    {
        // first sort the children so they are retrieved by priority
        uasort($this->elements, array($this, 'childComparator'));

        return $this->elements;
    }


    /**
     * Unset the group property for elements without a valid group (ie: existing group)
     */
    protected function cleanUpMissingGroups()
    {
        foreach ($this->elements as $element) {
            $group = $element->getGroup();
            if ($group && !isset($this->elements[$group])) {
                $element->setGroup(null);
            }
        }
    }

}
