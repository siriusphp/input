<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;

class Submit extends Button
{

    protected function getDefaultSpecs()
    {
        return array(
            Element::WIDGET => 'button',
            Element::ATTRIBUTES => array(
                'type' => 'submit'
            )
        );
    }
}