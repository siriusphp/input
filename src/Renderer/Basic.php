<?php
namespace Sirius\Forms\Renderer;

use \Sirius\Forms\Form;
use \Sirius\Forms\WidgetFactory\FactoryInterface;
use \Sirius\Forms\WidgetFactory\Base as BaseFactory;
use \Sirius\Forms\Utils\PriorityList;
use \Sirius\Forms\Decorator\DecoratorInterface;

class Basic
{

    protected $widgetFactoriesList;

    protected $decoratorsList;

    function __construct(FactoryInterface $defaulWidgetFactory = null)
    {
        if (! $defaulWidgetFactory) {
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
    function addWidgetFactory(FactoryInterface $widgetFactory, $priority = 0)
    {
        if (! $this->widgetFactoriesList) {
            $this->widgetFactoriesList = new PriorityList();
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
    {}

    function getElementWidget(Form $form, $elementName)
    {}

    protected function decorateWidget($widget)
    {
        /* @var $decorator \Sirius\Decorator\DecoratorInterface */
        foreach ($this->decoratorsList->getIterator() as $decorator) {
            $decoratedWidget = $decorator->decorate($widget);
            if (! $decoratedWidget instanceof \Sirius\Forms\Html\ExtendedTag) {
                throw new \LogicException('A decorator returned something that is not an HTML tag');
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