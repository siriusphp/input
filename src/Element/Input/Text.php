<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;
use Sirius\Forms\Element\Traits\HasHintTrait;
use Sirius\Forms\Element\Traits\HasValidationRulesTrait;
use Sirius\Forms\Element\Traits\HasFiltersTrait;

class Text extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'text'
        );
    }
}
