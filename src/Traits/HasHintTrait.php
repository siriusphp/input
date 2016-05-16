<?php
namespace Sirius\Input\Traits;

use Sirius\Input\Specs;
use Sirius\Input\AttributesContainer;

trait HasHintTrait
{

    protected function ensureHintAttributes()
    {
        if (!isset($this[Specs::HINT_ATTRIBUTES])) {
            $this[Specs::HINT_ATTRIBUTES] = new AttributesContainer();
        }
    }

    /**
     * Retrieves the hint's text
     *
     * @return string|null
     */
    public function getHint()
    {
        return isset($this[Specs::HINT]) ? $this[Specs::HINT] : null;
    }

    /**
     * Sets the hint's text
     *
     * @param string $hint
     *
     * @return self
     */
    public function setHint($hint)
    {
        $this[Specs::HINT] = $hint;

        return $this;
    }

    /**
     * Retrieve all of the hint's attributes
     *
     * @return mixed
     */
    public function getHintAttributes()
    {
        $this->ensureHintAttributes();

        return $this[Specs::HINT_ATTRIBUTES]->getAll();
    }

    /**
     * Sets multiple attributes for the hint
     *
     * @param array $attrs
     *
     * @return HasHintTrait
     */
    public function setHintAttributes($attrs)
    {
        $this->ensureHintAttributes();
        $this[Specs::HINT_ATTRIBUTES]->set($attrs);

        return $this;
    }

    /**
     * Retrieve an attribute from the hint
     *
     * @param string $attr
     *
     * @return mixed
     */
    public function getHintAttribute($attr)
    {
        $this->ensureHintAttributes();

        return $this[Specs::HINT_ATTRIBUTES]->get($attr);
    }

    /**
     * Set/Unset a hint attribute
     *
     * @param string $attr
     * @param mixed|null $value
     *
     * @return self
     */
    public function setHintAttribute($attr, $value = null)
    {
        $this->ensureHintAttributes();
        $this[Specs::HINT_ATTRIBUTES]->set($attr, $value);

        return $this;
    }

    /**
     * Adds a CSS class to the hint's "class" attribute
     *
     * @param string $class
     *
     * @return self
     */
    public function addHintClass($class)
    {
        $this->ensureHintAttributes();
        $this[Specs::HINT_ATTRIBUTES]->addClass($class);

        return $this;
    }

    /**
     * Removes a CSS class from the hint's "class" attribute
     *
     * @param string $class
     *
     * @return self
     */
    public function removeHintClass($class)
    {
        $this->ensureHintAttributes();
        $this[Specs::HINT_ATTRIBUTES]->removeClass($class);

        return $this;
    }

    /**
     * Toggles a CSS class to the hint's "class" attribute
     *
     * @param
     *            $class
     *
     * @return self
     */
    public function toggleHintClass($class)
    {
        $this->ensureHintAttributes();
        $this[Specs::HINT_ATTRIBUTES]->toggleClass($class);

        return $this;
    }

    /**
     * Checks if the hint has a CSS class on the "class" attribute
     *
     * @param
     *            $class
     *
     * @return bool
     */
    public function hasHintClass($class)
    {
        $this->ensureHintAttributes();

        return $this[Specs::HINT_ATTRIBUTES]->hasClass($class);
    }
}
