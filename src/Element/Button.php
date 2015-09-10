<?php
namespace Sirius\Input\Element;

use Sirius\Input\Element;

class Button extends Element
{

    function getLabel()
    {
        return isset($this[Element::LABEL]) ? $this[Element::LABEL] : null;
    }

    function setLabel($label)
    {
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
