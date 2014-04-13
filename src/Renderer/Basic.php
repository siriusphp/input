<?php
namespace Sirius\Forms\Renderer;

use Sirius\Forms\Decorator\DecoratorInterface;
use Sirius\Forms\Form;
use Sirius\Forms\Html\ExtendedTag;
use Sirius\Forms\Utils\PriorityList;
use Sirius\Forms\WidgetFactory\Base as BaseFactory;
use Sirius\Forms\WidgetFactory\FactoryInterface;

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
        if (!$widgetFactory) {
            $widgetFactory = new BaseFactory();
        }
        $this->widgetFactory = $widgetFactory;
        $this->decoratorsList = new PriorityList();
    }

    /**
     * Add a decorator to the stack
     *
     * @param DecoratorInterface $decorator
     * @param int $priority
     * @return self
     */
    function addDecorator(DecoratorInterface $decorator, $priority = 0)
    {
        $this->decoratorsList->add($decorator, $priority);
        return $this;
    }

    /**
     *
     * @param Form $form
     * @return Ambigous <\Sirius\Forms\WidgetFactory\false, \Sirius\Form\Renderer\Widget\WidgetInterface>
     */
    function render(Form $form)
    {
        return $this->getFormWidget($form);
    }

    /**
     * Returns the widget associated with the form
     *
     * @param Form $form
     * @return NULL \Sirius\Forms\Html\ExtendedTag
     */
    function getFormWidget(Form $form)
    {
        $widget = $this->widgetFactory->createWidget($form);
        $this->decorateWidget($widget);
        return $widget;
    }

    /**
     * Returns the widget associated with an element from the form
     *
     * @param Form $form
     * @param string $elementName
     * @throws \RuntimeException
     * @return NULL \Sirius\Forms\Html\ExtendedTag
     */
    function renderElement(Form $form, $elementName)
    {
        $element = $form->get($elementName);
        if (!$element) {
            throw new \RuntimeException(sprintf('Input "%s" is not registered to this form'));
        }
        $widget = $this->widgetFactory->createWidget($form, $element);
        $this->decorateWidget($widget);
        return $widget;
    }

    /**
     * Applies the decorators to the widget
     *
     * @param ExtendedTag $widget
     * @throws \LogicException
     * @return ExtendedTag
     */
    protected function decorateWidget($widget)
    {
        if (!$widget instanceof ExtendedTag) {
            return $widget;
        }
        /* @var $decorator \Sirius\Forms\Decorator\DecoratorInterface */
        foreach ($this->decoratorsList->getIterator() as $decorator) {
            $decoratedWidget = $decorator->decorate($widget);
            if (!$decoratedWidget instanceof ExtendedTag) {
                throw new \LogicException(
                    'A decorator returned something that is not an \Sirius\Forms\Html\ExtendedTag object'
                );
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
