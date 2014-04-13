<?php
namespace Sirius\Forms\Element\Button;

use Sirius\Forms\Element;
use Sirius\Forms\Element\Button;

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
