<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;
use Sirius\Forms\Element\Input as BaseInput;

class Select extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            Element::WIDGET => 'select'
        );
    }
}