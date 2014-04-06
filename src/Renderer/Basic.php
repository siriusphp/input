<?php
namespace Sirius\Forms\Renderer;

use \Sirius\Forms\Form;
use \Sirius\Forms\WidgetFactory\FactoryInterface;
use \Sirius\Forms\WidgetFactory\Base as BaseFactory;
use \Sirius\Forms\Utils\PriorityList;
use \Sirius\Forms\Decorator\DecoratorInterface;

class Basic
{

    /**
     *
     * @var \Sirius\Forms\WidgetFactory\FactoryInterface
     */
    protected $widgetFactory;

    /**
     *
     * @var \Sirius\Forms\Util\PriorityList
     */
    protected $decoratorsList;

    function __construct(FactoryInterface $widgetFactory = null)
    {
        if (! $widgetFactory) {
            $widgetFactory = new BaseFactory();
        }
        $this->widgetFactory = $widgetFactory;
    }

    /**
     * Add a decorator to the stack
     *
     * @param AbstractDecorator $decorator            
     * @param number $priority            
     */
    function addDecorator(DecoratorInterface $decorator, $priority = 0)
    {
        if (! $this->decoratorsList) {
            $this->decoratorsList = new PriorityList();
        }
        $this->decoratorsList->add($decorator, $priority);
        return $this;
    }

    function render(Form $form)
    {
        return $this->getFormWidget($form);
    }

    function getFormWidget(Form $form)
    {
    	$widget = $this->widgetFactory->createWidget($form);
    	$this->decorateWidget($widget);
    	return $widget;
    }

    function renderElement(Form $form, $elementName)
    {

        $widget = $this->widgetFactory->createWidget($form, $elementName);
    	$this->decorateWidget($widget);
    	return $widget;
    }

    protected function decorateWidget($widget)
    {
        /* @var $decorator \Sirius\Forms\Decorator\DecoratorInterface */
        foreach ($this->decoratorsList->getIterator() as $decorator) {
            $decoratedWidget = $decorator->decorate($widget);
            if (! $decoratedWidget instanceof \Sirius\Forms\Html\ExtendedTag) {
                throw new \LogicException('A decorator returned something that is not an \Sirius\Forms\Html\ExtendedTag object');
            }
        }
        
        // If the widget has children, decorate them as well
        if ($widget instanceof Sirius\Forms\Renderer\WidgetTrait\HasChildrenTrait) {
            foreach ($widget->getChilren() as $childWidget) {
                $this->decorate($childWidget);
            }
        }
        
        return $widget;
    }
}