<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;
use Sirius\Forms\Element\Input as BaseInput;

class Textarea extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            Element::WIDGET => 'textarea',
            Element::ATTRIBUTES => array(
                'rows' => '5',
                'cols' => '100'
            )
        );
    }
}