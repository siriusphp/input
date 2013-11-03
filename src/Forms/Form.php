<?php

namespace Sirius\Forms;

use Sirius\Forms\Element\Collection;
use Sirius\Forms\ElementFactory;

class Form extends Collection{
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var ElementFactory
	 */
    protected $elementFactory;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var Filtrator
     */
    protected $filtrator;


    function __construct($name, $attrs = array()) {
    	parent::__construct($attrs);
    	$this->name = $name;
    }

    
    /**
     * return string
     */
    function getName() {
    	return $this->name;
    }

    /**
     * @param ElementFactory $elementFactory
     * @return \Sirius\Form
     */
    function setElementFactory(ElementFactory $elementFactory) {
		$this->elementFactory = $elementFactory;
        return $this;
    }

    /**
     * @return ElementFactory
     */
    function getElementFactory() {
		if (!$this->elementFactory) {
			$this->elementFactory = new ElementFactory();
		}
		return $this->elementFactory;
    }

    function set($name, $specsOrElement) {

    }

    function get($name) {

    }

    function remove($name) {
    	
    }
    
    function move($name, $reference, $type) {
    	
    }
    
    protected function moveAfter($name, $reference) {
    	
    }
    
    protected function moveTo($name, $reference) {
    	
    }
    
    protected function moveBefore($name, $reference) {
    	
    }
    
    function getValidator() {

    }

    function getFiltrator() {

    }

    function setValues($values) {

    }

    function getValues() {

    }

    function setFiles($files) {

    }

    function getFiles() {
        
    }

}