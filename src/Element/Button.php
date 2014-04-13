<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element;

class Button extends Element
{

    function getLabel() {
        return isset($this[Element::LABEL]) ? $this[Element::LABEL] : null;
    }

    function setLabel($label) {
        $this[Element::LABEL] = $label;
        return $this;
    }

    protected function getDefaultSpecs()
    {
        return array(
            Element::WIDGET => 'button'
        );
    }
}
