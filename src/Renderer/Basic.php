<?php
namespace Sirius\Forms\Renderer;

class Basic
{
	protected $widgetFactories = array() ;
	protected $decorators = array();
	
	function __construct(\Sirius\Forms\WidgetFactory $defaulWidgetFactory = null) {
	}

	function addWidgetFactory($widgetFactory, $priority = 0) {

	}

	function addDecorator($name, $decorator, $priority = 0) {
		
	}
	
	function removeDecorator($name) {
		
	}
	
	function render(\Sirius\Forms\Form $form) {
		
	}
}