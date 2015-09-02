<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;

class Text extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'text'
        );
    }
}
