<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;

trait HasLabelTrait {

    function getLabel() {
        return isset($this[Input::LABEL]) ? $this[Input::LABEL] : null;
    }

    function setLabel($label) {
        $this[Input::LABEL] = $label;
        return $this;
    }

    function getLabelAttributes() {
        return $this->getAttributesFor(Input::LABEL);
    }

    function setLabelAttributes($attrs) {
        return $this->setAttributesFor(Input::LABEL, $attrs);
    }

    function getLabelAttribute($attr) {
        return $this->getAttributeFor(Input::LABEL, $attr);
    }

    function setLabelAttribute($attr, $value = null) {
        return $this->setAttributeFor(Input::LABEL, $attr, $value);
    }

    function addLabelClass($class) {
        return $this->addClassFor(Input::LABEL, $class);
    }

    function removeLabelClass($class) {
        return $this->removeClassFor(Input::LABEL, $class);
    }

    function toggleLabelClass($class) {
        return $this->toggleClassFor(Input::LABEL, $class);
    }
}
