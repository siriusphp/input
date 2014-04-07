<?php
namespace Sirius\Forms\WidgetFactory;

use \Sirius\Forms\Form;
use \Sirius\Forms\Element\Specs;

interface FactoryInterface
{

    /**
     * Create a widget from a form element
     *
     * @param \Sirius\Forms\Form $form            
     * @param \Sirius\Forms\Element\Specs $element            
     * @return false \Sirius\Form\Renderer\Widget\WidgetInterface
     */
    function createWidget(Form $form, Specs $element = null);
}