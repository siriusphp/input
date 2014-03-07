<?php
namespace Sirius\Forms\Element;

class Input extends Element
{

    /**
     * Label component of a form element
     * 
     * @var HtmlElement
     */
    protected $label;

    /**
     * Container element ()
     * 
     * @var HtmlElement
     */
    protected $container;

    /**
     * The hint (instructions component of a form element
     * 
     * @var HtmlElement
     */
    protected $hint;

    /**
     * The error component which holds the error message
     * 
     * @var HtmlElement
     */
    protected $error;

    protected $rules;

    protected $filters;
}