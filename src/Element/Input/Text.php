<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;
use Sirius\Input\Specs;

class Text extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET => 'text'
        );
    }
}
