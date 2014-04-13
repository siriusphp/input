<?php
namespace Sirius\Forms\Element\Button;

use Sirius\Forms\Element;
use Sirius\Forms\Element\Button;

class Reset extends Button
{

    protected function getDefaultSpecs()
    {
        return array(
            Element::WIDGET => 'button',
            Element::ATTRIBUTES => array(
                'type' => 'reset'
            )
        );
    }
}
