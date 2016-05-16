<?php
namespace Sirius\Input\Element;

use Sirius\Input\Element;
use Sirius\Input\Specs;

class Button extends Element
{

    public function getLabel()
    {
        return isset($this[Specs::LABEL]) ? $this[Specs::LABEL] : null;
    }

    public function setLabel($label)
    {
        $this[Specs::LABEL] = $label;

        return $this;
    }

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET => 'button'
        );
    }
}
