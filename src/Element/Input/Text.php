<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;

class Text extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'text'
        );
    }
}
