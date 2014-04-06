<?php

namespace Sirius\Forms\WidgetFactory;

interface FactoryInterface {
    
    /**
     * Create a widget from a form element
     * 
     * @param \Sirius\Forms\Form $form
     * @param string $elementName
     * @return false|\Sirius\Form\Renderer\Widget\WidgetInterface
     */
    function createWidget(\Sirius\Forms\Element\ContainerTrait $form, $elementName = null);
}