<?php
namespace Sirius\Forms\WidgetFactory;

use Sirius\Forms\Element\AbstractElement;
use Sirius\Forms\Form;

interface FactoryInterface
{

    /**
     * Create a widget from a form element
     *
     * @param \Sirius\Forms\Form $form
     * @param \Sirius\Forms\Element\AbstractElement $element
     * @return false \Sirius\Form\Html\ExtendedTag
     */
    function createWidget(Form $form, AbstractElement $element = null);
}
