<?php
namespace Sirius\Forms;

use Sirius\Forms\Decorator\DecoratorInterface;
use Sirius\Forms\Form;
use Sirius\Forms\Html\ExtendedTag;
use Sirius\Forms\WidgetFactory\Base as BaseFactory;
use Sirius\Forms\WidgetFactory\FactoryInterface;

class Renderer
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
     * @return NULL|\Sirius\Forms\Html\ExtendedTag
     */
    function getFormWidget(Form $form)
    {
        $widget = $this->widgetFactory->createWidget($form);
        return $widget;
    }

    /**
     * Returns the widget associated with an element from the form
     *
     * @param Form $form
     * @param string $elementName
     * @throws \RuntimeException
     * @return NULL|\Sirius\Forms\Html\ExtendedTag
     */
    function getElementWidget(Form $form, $elementName)
    {
        $element = $form->get($elementName);
        if (!$element) {
            throw new \RuntimeException(sprintf('Input "%s" is not registered to this form'));
        }
        $widget = $this->widgetFactory->createWidget($form, $element);
        return $widget;
    }
}
