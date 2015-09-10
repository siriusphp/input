<?php
namespace Sirius\Input\Element\Button;

use Sirius\Input\Element;
use Sirius\Input\Element\Button;

class Submit extends Button
{

    protected function getDefaultSpecs()
    {
        return array(
            Element::WIDGET     => 'button',
            Element::ATTRIBUTES => array(
                'type' => 'submit'
            )
        );
    }
}
