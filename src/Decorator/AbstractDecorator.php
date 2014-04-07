<?php
namespace Sirius\Forms\Decorator;

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

    function decorate(\Sirius\Forms\Html\ExtendedTag $widget)
    {
        return $widget;
    }
}