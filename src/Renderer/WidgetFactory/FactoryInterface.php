<?php

namespace Sirius\Forms\WidgetFactory;

interface FactoryInterface {
    
    /**
     * Create a widget from a form element
     * 
     * @param \Sirius\Forms\Form $form
     * @param \Sirius\Forms\Specs $formElement
     * @return false|\Sirius\Form\Renderer\Widget\WidgetInterface
     */
    function createFormElement(\Sirius\Forms\Form $form, \Sirius\Forms\Specs $formElement);
}