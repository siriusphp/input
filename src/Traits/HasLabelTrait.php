<?php
namespace Sirius\Input\Traits;

use Sirius\Input\Specs;
use Sirius\Input\AttributesContainer;

trait HasLabelTrait
{

    protected function ensureLabelAttributes()
    {
        if ( ! isset($this[Specs::LABEL_ATTRIBUTES])) {
            $this[Specs::LABEL_ATTRIBUTES] = new AttributesContainer();
        }
    }

    /**
     * Retrieves the label's text
     *
     * @return string null
     */
    function getLabel()
    {
        return isset($this[Specs::LABEL]) ? $this[Specs::LABEL] : null;
    }

    /**
     * Sets the label's text
     *
     * @param string $label
     *
     * @return self
     */
    function setLabel($label)
    {
        $this[Specs::LABEL] = $label;

        return $this;
    }

    /**
     * Retrieve all of the label's attributes
     *
     * @return mixed
     */
    function getLabelAttributes()
    {
        $this->ensureLabelAttributes();

        return $this[Specs::LABEL_ATTRIBUTES]->getAll();
    }

    /**
     * Sets multiple attributes for the label
     *
     * @param array $attrs
     *
     * @return mixed
     */
    function setLabelAttributes($attrs)
    {
        $this->ensureLabelAttributes();
        $this[Specs::LABEL_ATTRIBUTES]->set($attrs);

        return $this;
    }

    /**
     * Retrieve an attribute from the label
     *
     * @param string $attr
     *
     * @return mixed
     */
    function getLabelAttribute($attr)
    {
        $this->ensureLabelAttributes();

        return $this[Specs::LABEL_ATTRIBUTES]->get($attr);
    }

    /**
     * Set/Unset a label attribute
     *
     * @param string $attr
     * @param mixed|null $value
     *
     * @return self
     */
    function setLabelAttribute($attr, $value = null)
    {
        $this->ensureLabelAttributes();
        $this->ensureLabelAttributes();
        $this[Specs::LABEL_ATTRIBUTES]->set($attr, $value);

        return $this;
    }

    /**
     * Adds a CSS class to the label's "class" attribute
     *
     * @param string $class
     *
     * @return self
     */
    function addLabelClass($class)
    {
        $this->ensureLabelAttributes();
        $this[Specs::LABEL_ATTRIBUTES]->addClass($class);

        return $this;
    }

    /**
     * Removes a CSS class from the label's "class" attribute
     *
     * @param string $class
     *
     * @return self
     */
    function removeLabelClass($class)
    {
        $this->ensureLabelAttributes();
        $this[Specs::LABEL_ATTRIBUTES]->removeClass($class);

        return $this;
    }

    /**
     * Toggles a CSS class to the label's "class" attribute
     *
     * @param
     *            $class
     *
     * @return self
     */
    function toggleLabelClass($class)
    {
        $this->ensureLabelAttributes();
        $this[Specs::LABEL_ATTRIBUTES]->toggleClass($class);

        return $this;
    }

    /**
     * Checks if the label has a CSS class on the "class" attribute
     *
     * @param
     *            $class
     *
     * @return bool
     */
    function hasLabelClass($class)
    {
        $this->ensureLabelAttributes();

        return $this[Specs::LABEL_ATTRIBUTES]->hasClass($class);
    }
}
