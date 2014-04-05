<?php

namespace Sirius\Forms\Renderer\WidgetFactory;

use Sirius\Forms\WidgetFactory\FactoryInterface;

class Base implements FactoryInterface{
	protected $widgetTypes = [];
	
    /**
     * Register a constructor for a widget type
     * 
     * @param string $type type of the widget that it handles
     * @param closure $callable the closure that will be used to generate the widget type
     * @return self
     */
	function registerWidgetTypeConstructor($type, $callable) {
		if ($callable instanceof \Closure) {
		    $this->widgetTypes[$type] = $callable;
		    return $this;
		}
		throw new \LogicException(sprintf('The widget constructor for %s type must be a class or a closure'));
	}

	function createFormElement(\Sirius\Forms\Specs $formElement) {
		
	}
}