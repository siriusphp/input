<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;

class Textarea extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'textarea',
            BaseInput::ATTRIBUTES => array(
                'rows' => '5',
                'cols' => '100'
            )
        );
    }
}