<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element;

trait HasLabelTrait {

    /**
     * Retrieves the label's text
     *
     * @return string|null
     */
    function getLabel()
    {
        return isset($this[Element::LABEL]) ? $this[Element::LABEL] : null;
    }

    /**
     * Sets the label's text
     *
     * @param string $label
     * @return self
     */
    function setLabel($label)
    {
        $this[Element::LABEL] = $label;
        return $this;
    }

    /**
     * Retrieve all of the label's attributes
     *
     * @return mixed
     */
    function getLabelAttributes()
    {
        return $this->getAttributesFor(Element::LABEL);
    }

    /**
     * Sets multiple attributes for the label
     *
     * @param array $attrs
     * @return mixed
     */
    function setLabelAttributes($attrs)
    {
        return $this->setAttributesFor(Element::LABEL, $attrs);
    }

    /**
     * Retrieve an attribute from the label
     *
     * @param string $attr
     * @return mixed
     */
    function getLabelAttribute($attr)
    {
        return $this->getAttributeFor(Element::LABEL, $attr);
    }

    /**
     * Set/Unset a label attribute
     *
     * @param string $attr
     * @param mixed|null $value
     * @return self
     */
    function setLabelAttribute($attr, $value = null)
    {
        return $this->setAttributeFor(Element::LABEL, $attr, $value);
    }

    /**
     * Adds a CSS class to the label's "class" attribute
     *
     * @param string $class
     * @return self
     */
    function addLabelClass($class)
    {
        return $this->addClassFor(Element::LABEL, $class);
    }

    /**
     * Removes a CSS class from the label's "class" attribute
     *
     * @param string $class
     * @return self
     */
    function removeLabelClass($class)
    {
        return $this->removeClassFor(Element::LABEL, $class);
    }

    /**
     * Toggles a CSS class to the label's "class" attribute
     *
     * @param $class
     * @return self
     */
    function toggleLabelClass($class)
    {
        return $this->toggleClassFor(Element::LABEL, $class);
    }

    /**
     * Checks if the label has a CSS class on the "class" attribute
     *
     * @param $class
     * @return bool
     */
    function hasLabelClass($class)
    {
        return $this->hasClassOn(Element::LABEL, $class);
    }
}
