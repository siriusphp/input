<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;

class Reset extends Button
{

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'button',
            BaseInput::ATTRIBUTES => array(
                'type' => 'reset'
            )
        );
    }
}