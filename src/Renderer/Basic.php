<?php
namespace Sirius\Forms\Renderer;

class Basic
{
	protected $widgetFactory ;
	protected $decorators = array();
	
	function __construct(\Sirius\Forms\WidgetFactory $widgetFactory = null) {
		
	}
	
	function addDecorator($name, $decorator, $priority) {
		
	}
	
	function removeDecorator($name) {
		
	}
	
	function render(\Sirius\Forms\Form $form) {
		
	}
}