<?php

namespace Sirius\Forms\Decorator;

abstract class AbstractDecorator {
	protected $options = array();
	
	function __construct($options = array()) {
		
	}
	
	function setOption($name, $value) {
		$this->options[$name] = $value;
		return $this;		
	}
	
	function getOption($name) {
		return isset($this->options[$name]) ? $this->options[$name] : null;
	}
	
	abstract function decorate($widget);
	
}