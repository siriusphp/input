<?php

namespace Sirius\Forms\Decorator;

interface DecoratorInterface {
    
    /**
     * Decorates a form widget
     * 
     * @param string|Sirius\Forms\Widget\Base $widget
     * @return string|Sirius\Forms\Wdiget\Base
     */
    function decorate($widget);
}