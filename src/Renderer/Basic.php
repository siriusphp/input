<?php
namespace Sirius\Forms\Renderer;

use \Sirius\Forms\Form;
use \Sirius\Forms\WidgetFactory\FactoryInterface;
use \Sirius\Forms\WidgetFactory\Base as BaseFactory;
use \Sirius\Forms\Decorator\AbstractDecorator;
use \Sirius\Forms\Utils\PriorityList;

class Basic
{
	protected $widgetFactoriesList;
	protected $decoratorsList;
	
	function __construct(FactoryInterface $defaulWidgetFactory = null) {
	    if (!$defaulWidgetFactory) {
	        $defaulWidgetFactory = new BaseFactory();
	    }
	    $this->addWidgetFactory($defaulWidgetFactory, 9999);
	}

    /**
     * Add a widget factory to the factory stack
     * 
     * @param FactoryInterface $widgetFactory            
     * @param number $priority            
     * @return \Sirius\Forms\Renderer\Basic
     */
    function addWidgetFactory(FactoryInterface $widgetFactory, $priority = 0) {
        if (!$this->widgetFactoriesList) {
            $this->widgetFactoriesList = new PriorityList;
        }
        $this->widgetFactoriesList->add($widgetFactory, $priority);
        return $this;
	}
	
	/**
	 * Add a decorator to the stack
	 * 
	 * @param AbstractDecorator $decorator
	 * @param number $priority
	 */
	function addDecorator(AbstractDecorator $decorator, $priority = 0) {
	    if (!$this->decoratorsList) {
	        $this->decoratorsList = new PriorityList;
	    }
	    $this->decoratorsList->add($decorator, $priority);
	    return $this;
	}
	
	function render(Form $form) {
		
	}
	
	
}