<?php

namespace Sirius\Forms\Decorator;

use Sirius\Forms\Html\ExtendedTag;

interface DecoratorInterface
{

    /**
     * Decorates a form widget
     *
     * @param ExtendedTag $widget
     * @return ExtendedTag
     */
    function decorate(ExtendedTag $widget);
}
