<?php
namespace Sirius\Forms\Decorator;

use Sirius\Forms\Html\ExtendedTag;

abstract class AbstractDecorator implements DecoratorInterface
{

    /**
     * The decorator's configuration options
     *
     * @var array
     */
    protected $options = array();

    function __construct($options = array())
    {
        $this->options = $options;
    }

    function decorate(ExtendedTag $widget)
    {
        return $widget;
    }
}
