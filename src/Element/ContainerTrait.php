<?php

namespace Sirius\Forms\Element;

trait ContainerTrait {
    protected $elements = array();
    
    /**
     * Add element to the container
     * 
     * @param string $name
     * @param \Sirius\Forms\Element $element
     * @return \Sirius\Forms\ElementContainer
     */
    protected function addToElementContainer($name, \Sirius\Forms\Element $element) {
        $this->elements[$name] = $element;
        return $this;
    }
    
    /**
     * Remove element from container
     * 
     * @param string $name
     * @return \Sirius\Forms\ElementContainer
     */
    protected function removeFromElementContainer($name) {
        if (isset($this->elements[$name])) {
            unset($this->elements[$name]);
        }
        return $this;
    }
    
    /**
     * Retrieve element from container
     * 
     * @param string $name
     * @return \Sirius\Forms\Element|boolean
     */
    protected function getFromElementContainer($name) {
        if (isset($this->elements[$name])){
            return $this->elements[$name];
        }
        return false;
    }
    
    /**
     * Element comparator callback
     * 
     * @param \ArrayObject $childA
     * @param \ArrayObject $childB
     * @return number
     */
    protected function childComparator($childA, $childB) {
        if ($childA['priority'] < $childB['priority']) {
            return -1;
        }
        if ($childA['priority'] > $childB['priority']) {
            return 1;
        }
        if ($childA['index'] < $childB['index']) {
            return -1;
        }
        if ($childA['index'] > $childB['index']) {
            return 1;
        }
        return 0;
    }
    
    /**
     * Returns the list of the elements organized by priority
     * 
     * @return array
     */
    function getChildren() {
        // first sort the children so they are retrieved by priority
        uasort($this->elements, array($this, 'childComparator'));
        return $this->elements;
    }
    
}