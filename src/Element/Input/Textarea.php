<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;
use Sirius\Input\Element;

class Textarea extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            Element::WIDGET     => 'textarea',
            Element::ATTRIBUTES => array(
                'rows' => '5',
                'cols' => '100'
            )
        );
    }
}
