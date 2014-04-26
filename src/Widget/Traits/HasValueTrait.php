<?php
namespace Sirius\Forms\Widget\Traits;

trait HasValueTrait
{

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var mixed
     */
    protected $rawValue;

    /**
     * Set the value of this element (fieldset/collection/form)
     *
     * @param mixed $value
     * @return $this
     */
    function setValue($value = null)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get the value of this element (fieldset/collection/form)
     *
     * @return mixed
     */
    function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of this element (fieldset/collection/form)
     *
     * @param mixed $value
     * @return $this
     */
    function setRawValue($value = null)
    {
        $this->rawValue = $value;
        return $this;
    }

    /**
     * Get the value of this element (fieldset/collection/form)
     *
     * @return mixed
     */
    function getRawValue()
    {
        return $this->rawValue;
    }
}
