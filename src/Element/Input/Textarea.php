<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;
use Sirius\Forms\Element;

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
