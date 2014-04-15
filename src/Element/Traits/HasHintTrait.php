<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element;

trait HasHintTrait
{

    /**
     * Retrieves the hint's text
     *
     * @return string|null
     */
    function getHint()
    {
        return isset($this[Element::HINT]) ? $this[Element::HINT] : null;
    }

    /**
     * Sets the hint's text
     *
     * @param string $hint
     * @return self
     */
    function setHint($hint)
    {
        $this[Element::HINT] = $hint;
        return $this;
    }

    /**
     * Retrieve all of the hint's attributes
     *
     * @return mixed
     */
    function getHintAttributes()
    {
        return $this->getAttributesFor(Element::HINT);
    }

    /**
     * Sets multiple attributes for the hint
     *
     * @param array $attrs
     * @return mixed
     */
    function setHintAttributes($attrs)
    {
        return $this->setAttributesFor(Element::HINT, $attrs);
    }

    /**
     * Retrieve an attribute from the hint
     *
     * @param string $attr
     * @return mixed
     */
    function getHintAttribute($attr)
    {
        return $this->getAttributeFor(Element::HINT, $attr);
    }

    /**
     * Set/Unset a hint attribute
     *
     * @param string $attr
     * @param mixed|null $value
     * @return self
     */
    function setHintAttribute($attr, $value = null)
    {
        return $this->setAttributeFor(Element::HINT, $attr, $value);
    }

    /**
     * Adds a CSS class to the hint's "class" attribute
     *
     * @param string $class
     * @return self
     */
    function addHintClass($class)
    {
        return $this->addClassFor(Element::HINT, $class);
    }

    /**
     * Removes a CSS class from the hint's "class" attribute
     *
     * @param string $class
     * @return self
     */
    function removeHintClass($class)
    {
        return $this->removeClassFor(Element::HINT, $class);
    }

    /**
     * Toggles a CSS class to the hint's "class" attribute
     *
     * @param $class
     * @return self
     */
    function toggleHintClass($class)
    {
        return $this->toggleClassFor(Element::HINT, $class);
    }

    /**
     * Checks if the hint has a CSS class on the "class" attribute
     *
     * @param $class
     * @return bool
     */
    function hasHintClass($class)
    {
        return $this->hasClassOn(Element::HINT, $class);
    }

}
