<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;
use Sirius\Input\Specs;

class Checkbox extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET => 'checkbox'
        );
    }

    public function setUncheckedValue($val = null)
    {
        $this[Specs::UNCHECKED_VALUE] = (string) $val;

        return $this;
    }

    public function getUncheckedValue()
    {
        return isset($this[Specs::UNCHECKED_VALUE]) ? $this[Specs::UNCHECKED_VALUE] : null;
    }

    public function setCheckedValue($val = null)
    {
        $this[Specs::CHECKED_VALUE] = (string) $val;

        return $this;
    }

    public function getCheckedValue()
    {
        return isset($this[Specs::CHECKED_VALUE]) ? $this[Specs::CHECKED_VALUE] : null;
    }

}
