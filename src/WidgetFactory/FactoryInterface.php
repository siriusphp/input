<?php
namespace Sirius\Forms\WidgetFactory;

use Sirius\Forms\Element;
use Sirius\Forms\Form;

interface FactoryInterface
{

    /**
     * Create a widget from a form element
     *
     * @param \Sirius\Forms\Form $form
     * @param \Sirius\Forms\Element $element
     * @return false|\Sirius\Forms\Html\ExtendedTag
     */
    function createWidget(Form $form, Element $element = null);
}
