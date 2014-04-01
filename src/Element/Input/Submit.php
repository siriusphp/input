<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;

class Submit extends Button
{

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'button',
            BaseInput::ATTRIBUTES => array(
                'type' => 'submit'
            )
        );
    }
}