<?php
namespace Sirius\Forms\Html;

/**
 * Base class for input elements.
 * Besides a regular HTML element input elements have a name and a value.
 *
 * @see \Sirius\Forms\Renderer\Widget\Base
 */
class Input extends ExtendedTag
{

    protected $tag = 'input';

    protected $isSelfClosing = true;

    /**
     * Value of the input field
     *
     * @var mixed
     */
    protected $value;

    function __construct($options = array())
    {
        parent::__construct($options);
        if (isset($options['value'])) {
            $this->setValue($options['value']);
        }
        if (isset($options['name'])) {
            $this->name = $options['name'];
            $this->setAttribute('name', $options['name']);
        }
    }

    /**
     * Set value of the input element
     *
     * @param string $val            
     * @return \Sirius\Forms\Renderer\Widget\Input
     */
    function setValue($val)
    {
        $this->value = $val;
        return $this;
    }

    /**
     * Get value of the input element
     *
     * @return string
     */
    function getValue()
    {
        return $this->value;
    }
}