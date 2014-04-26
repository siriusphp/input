<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element;

trait HasContainerTrait
{

    /**
     * Retrieve all of the container's attributes
     *
     * @return mixed
     */
    function getContainerAttributes()
    {
        return $this->getAttributesFor('container');
    }

    /**
     * Sets multiple attributes for the container
     *
     * @param array $attrs
     * @return mixed
     */
    function setContainerAttributes($attrs)
    {
        return $this->setAttributesFor('container', $attrs);
    }

    /**
     * Retrieve an attribute from the container
     *
     * @param string $attr
     * @return mixed
     */
    function getContainerAttribute($attr)
    {
        return $this->getAttributeFor('container', $attr);
    }

    /**
     * Set/Unset a hint attribute
     *
     * @param string $attr
     * @param mixed|null $value
     * @return self
     */
    function setContainerAttribute($attr, $value = null)
    {
        return $this->setAttributeFor('container', $attr, $value);
    }

    /**
     * Adds a CSS class to the container's "class" attribute
     *
     * @param string $class
     * @return self
     */
    function addContainerClass($class)
    {
        return $this->addClassFor('container', $class);
    }

    /**
     * Removes a CSS class from the container's "class" attribute
     *
     * @param string $class
     * @return self
     */
    function removeContainerClass($class)
    {
        return $this->removeClassFor('container', $class);
    }

    /**
     * Toggles a CSS class to the container's "class" attribute
     *
     * @param $class
     * @return self
     */
    function toggleContainerClass($class)
    {
        return $this->toggleClassFor('container', $class);
    }

    /**
     * Checks if the container has a CSS class on the "class" attribute
     *
     * @param $class
     * @return bool
     */
    function hasContainerClass($class)
    {
        return $this->hasClassOn('container', $class);
    }

}
