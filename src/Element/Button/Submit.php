<?php
namespace Sirius\Input\Element\Button;

use Sirius\Input\Specs;
use Sirius\Input\Element\Button;

class Submit extends Button
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET     => 'button',
            Specs::ATTRIBUTES => array(
                'type' => 'submit'
            )
        );
    }
}
