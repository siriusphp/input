<?php
namespace Sirius\Forms\Element;

use \Sirius\Forms\Element;
use \Sirius\Forms\ElementFactory;
use \Sirius\Forms\ElementFactoryAwareInterface;

/**
 * A fielset is a special kind of form element that has a namespace
 * If a fielset contains an address its name will be `address` and will contain
 * children like `street_name`, `city`, `zip_code` etc.
 * Children will be rendered as `address[street_name]`, `address[city]` etc
 */
class Fieldset extends Element implements ElementFactoryAwareInterface {
	protected $defaultSpecs = array(
		Element::WIDGET => 'fieldset'
	);
	
	protected $elementFactory;
	
    protected $children = array();

    protected function getFullChildName($name) {
    	$firstOpenBracket = strpos($name, '[');
    	// the name is already at least 2 levels deep like street[name]
    	if ($firstOpenBracket !== -1) {
    		return $this->getName . '[' . str_replace('[', '][', $name, 1);
    	}
    	return $this->getName() . '[' . $name . ']';
    }
    
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
     * Sets the element factory
     * 
     * @param ElementFactory $elementFactory            
     * @return self
     */
    function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;
        return $this;
    }

    protected function createChildElementFromSpecs(array $specs) {
   		// index will be used for sorting
   		// if 2 elements are added with the same priority the index will determine the position
   		$specs['index'] = count($this->children);
   		$element = $this->elementFactory->create($this->getFullChildName($name), $specs);
   		$element->setForm($this);
		return $element;
    }
    
    function add($name, $elementOrSpecs) {
    	if (!$this->elementFactory && !$elementOrSpecs instanceof Element) {
    		thrown new \RuntimeException('A fieldset must have an element factory in order to be able to construct elements');
    	}

    	$element = ($elementOrSpecs instanceof Element)
    			? $elementOrSpecs
    			: $this->createChildElementFromSpecs($elementOrSpecs);
    	
    	$this->children[$name] = $element;
    	return $this;
    }
    
    function get($name) {
    	return $this->has($name) ? $this->children[$name] : null;
    }
    
    function has($name) {
    	return isset($this->children[$name]);
    }
    
    function remove($name) {
    	if ($this->has($name)) {
    		unset($this->children[$name]);
    	}
    	return $this;
    }
    
    function getChildren() {
    	// first sort the children so they are retrieved by priority
    	uasort($this->children, array($this, 'childComparator'));
    	return $this->children;
    }
}