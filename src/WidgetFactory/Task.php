<?php
namespace Sirius\Forms\WidgetFactory;

use Sirius\Forms\Element\Specs;
use Sirius\Forms\Form;
use Sirius\Forms\Html\ExtendedTag;

class Task
{

    /**
     *
     * @var FactoryInterface
     */
    protected $widgetFactory;

    /**
     *
     * @var Form
     */
    protected $form;

    /**
     *
     * @var Specs
     */
    protected $element;

    function __construct(FactoryInterface $widgetFactory, Form $form, Specs $element)
    {
        $this->widgetFactory = $widgetFactory;
        $this->form = $form;
        $this->element = $element;
        $this->result = null;
    }

    /**
     * Get the widget factory associated with this task
     *
     * @return \Sirius\Forms\WidgetFactory\FactoryInterface
     */
    function getWidgetFactory()
    {
        return $this->widgetFactory;
    }

    /**
     * Return the form that is going to be handled during the execution of this task
     *
     * @return \Sirius\Forms\Form
     */
    function getForm()
    {
        return $this->form;
    }

    /**
     * Return the element that is going to be handled during the execution of this task
     *
     * @return \Sirius\Forms\Element\Specs
     */
    function getElement()
    {
        return $this->element;
    }

    /**
     * Sets the result of the task
     *
     * @param ExtendedTag $result
     */
    function setResult(ExtendedTag $result)
    {
        $this->result = $result;
    }

    /**
     * Returns the result of the execution of the task
     *
     * @return NULL|ExtendedTag
     */
    function getResult()
    {
        return $this->result;
    }
}
