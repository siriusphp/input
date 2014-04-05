<?php

namespace Sirius\Forms\Decorator;

abstract class AbstractDecorator implements DecoratorInterface {
	protected $options = array();
	
	function __construct($options = array()) {
		$this->options = $options;
	}
	
	/**
	 * Set a configuration option for the decorator
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return \Sirius\Forms\Decorator\AbstractDecorator
	 */
	function setOption($name, $value) {
		$this->options[$name] = $value;
		return $this;		
	}
	
	/**
	 * Get a configuration option from the decorator
	 * 
	 * @param string $name
	 * @return Ambigous <NULL, multitype:>
	 */
	function getOption($name) {
		return isset($this->options[$name]) ? $this->options[$name] : null;
	}
	
	function decorate(\Sirius\Forms\Html\ExtendedTag $widget) {
	    return $widget;
	}
	
}