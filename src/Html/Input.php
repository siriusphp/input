<?php
namespace Sirius\Forms\Html;

use Sirius\Forms\Html\Tag;

/**
 * Base class for input elements.
 * Besides a regular HTML element input elements have a name and a value.
 *
 * @see \Sirius\Forms\Renderer\Widget\Base
 */
abstract class Input extends Tag
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
            $this->value($options['value']);
        }
        if (isset($options['name'])) {
            $this->name = $options['name'];
            $this->attr('name', $options['name']);
        }
    }

    /**
     * Getter/Setter method for the value of the input field
     *
     * @param string $val            
     * @return string \Sirius\Forms\Renderer\Widget\Input
     */
    function value($val = null)
    {
        if (count(func_get_args()) === 0) {
            return $this->getValue();
        } else {
            return $this->setValue($val);
        }
    }

    /**
     * Set value of the input element
     *
     * @param string $val            
     * @return \Sirius\Forms\Renderer\Widget\Input
     */
    protected function setValue($val)
    {
        $this->value = $val;
        return $this;
    }

    /**
     * Get value of the input element
     *
     * @return string
     */
    protected function getValue()
    {
        return $this->value;
    }
}