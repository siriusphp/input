<?php

namespace Sirius\Forms\Renderer\WidgetFactory;

use Sirius\Forms\WidgetFactory\FactoryInterface;

class Base implements FactoryInterface{
	protected $widgetTypes = [];
	
    /**
     * Register a constructor for a widget type
     * 
     * @param string $type type of the widget that it handles
     * @param class|closure $classOrClosure the class/closure that will be used to generate the widget type
     * @return self
     */
	function registerWidgetTypeConstructor($type, $classOrClosure) {
		if ($classOrClosure instanceof \Closure) {
		    $this->widgetTypes[$type] = $classOrClosure;
		    return $this;
		}
		if (is_string($classOrClosure) && class_exists($classOrClosure)) {
		    $this->widgetTypes[$type] = $classOrClosure;
		    return $this;
		}
		throw new \LogicException(sprintf('The widget constructor for %s type must be a class or a closure'));
	}

	function createFromElement(\Sirius\Forms\Specs $formElement) {
		
	}
}