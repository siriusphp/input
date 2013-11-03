<?php

namespace Sirius\Forms;

use Sirius\Forms\Form;
use Sirius\Forms\Validation\Rules as ValidationRules;
use Sirius\Forms\Filters;
use Sirius\Forms\Html\Element as HtmlElement;

class Element extends HtmlElement {
	/**
	 * @var \Sirius\Forms\Form
	 */
	protected $form;
	
	/**
	 * @var string
	 */
	protected $name;
	
	protected $priority;
	
	protected $parent;
	
	protected $options = array();
	
    /**
     * @param string $name Name of the form element that will make it identifiable
     * @param array $specs Specification for the element (attributes, parents, etc)
     */
    function __construct($name, $specs = array()) {
    	$this->name = $name;
    	$this->applyChanges($specs);
    }

    function setSpecs ($specs = array()) {
    	foreach ($specs as $key => $value) {
    		switch ($key) {
    			case 'priority':
    			break;
    			case 'parent':
    			break;
    			case 'attrs':
    			break;
    		}
    	}
    	return $this;
    }
    
    function setForm ($form) {
		$this->form = $form;
		return $this;
    }

    function getForm($form) {
    	
    }
    
    function setValue ($value) {

    }

    function getValue () {
        
    }
    
    function setOption ($name, $value) {
    	
    	return $this;
    }
    
    function getOption ($name) {
    	
    }
    
    function setPriority ($priority) {
    	
    }
    
    function getPriority () {
    	
    }

    function setParent($parent) {
    	
    }
    
    function getParent() {
    	
    }

}

$el = new Element('login');
$el->