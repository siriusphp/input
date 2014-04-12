<?php
namespace Sirius\Forms\WidgetFactory;

use Sirius\Forms\Element\Specs;
use Sirius\Forms\Form;

interface FactoryInterface
{

    /**
     * Create a widget from a form element
     *
     * @param \Sirius\Forms\Form $form
     * @param \Sirius\Forms\Element\Specs $element
     * @return false \Sirius\Form\Html\ExtendedTag
     */
    function createWidget(Form $form, Specs $element = null);
}
