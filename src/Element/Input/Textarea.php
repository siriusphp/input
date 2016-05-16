<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;
use Sirius\Input\Specs;

class Textarea extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET     => 'textarea',
            Specs::ATTRIBUTES => array(
                'rows' => '5',
                'cols' => '100'
            )
        );
    }
}
