<?php

namespace Sirius\Forms\Decorator;

interface DecoratorInterface {
    
    /**
     * Decorates a form widget
     * 
     * @param \Sirius\Forms\Html\ExtendedTag $widget
     * @return \Sirius\Forms\Html\ExtendedTag
     */
    function decorate(\Sirius\Forms\Html\ExtendedTag $widget);
}