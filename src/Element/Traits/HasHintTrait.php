<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;

trait HasHintTrait {

    function getHint() {
        return isset($this[Input::HINT]) ? $this[Input::HINT] : null;
    }

    function setHint($hint) {
        $this[Input::HINT] = $hint;
        return $this;
    }

    function getHintAttributes() {
        return $this->getAttributesFor(Input::HINT);
    }

    function setHintAttributes($attrs) {
        return $this->setAttributesFor(Input::HINT, $attrs);
    }

    function getHintAttribute($attr) {
        return $this->getAttributeFor(Input::HINT, $attr);
    }

    function setHintAttribute($attr, $value = null) {
        return $this->setAttributeFor(Input::HINT, $attr, $value);
    }

    function addHintClass($class) {
        return $this->addClassFor(Input::HINT, $class);
    }

    function removeHintClass($class) {
        return $this->removeClassFor(Input::HINT, $class);
    }

    function toggleHintClass($class) {
        return $this->toggleClassFor(Input::HINT, $class);
    }
}
