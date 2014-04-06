<?php

namespace Sirius\Forms\Renderer\WidgetFactory;

use Sirius\Forms\WidgetFactory\FactoryInterface;

class Base implements FactoryInterface{
	protected $widgetTypes = array();
	
	protected $typeToMethodMap = array(
		'text' => 'createTextWidget',
		'textarea' => 'createTextareaWidget',
		'hidden' => 'createHiddenWidget',
		'checkbox' => 'createCheckboxWidget',
	);
	
	function __construct() {
	    foreach ($this->typeToMethodMap as $type => $method) {
	        $this->registerWidgetTypeConstructor($type, array($this, $method), 9999);
	    }
	}
	
    /**
     * Register a constructor for a widget type
     * 
     * @param string $type type of the widget that it handles
     * @param closure $callable the closure that will be used to generate the widget type
     * @return self
     */
	function registerWidgetTypeConstructor($type, $callable, $priority = 0) {
		if ($callable instanceof \Closure) {
		    if (!$this->widgetTypes[$type]) {
		        $this->widgetTypes[$type] = new \Sirius\Forms\Util\PriorityList();
		    }
		    $this->widgetTypes[$type]->add($callable, $priority);
		    return $this;
		}
		throw new \LogicException(sprintf('The widget constructor for %s type must be a class or a closure'));
	}

	function createWidget(\Sirius\Forms\Element\ContainerTrait $form, $elementName = null)
	{
	    if ($elementName == null) {
	        return $this->createFormWidget($form);
	    }
	    
	    if (!$form->has($elementName)) {
	        return null;
	    }
	    
	    if (!)
	}
	
	protected function createFormWidget(\Sirius\Forms\Element\ContainerTrait $form) {
	    
	}
	
	
}