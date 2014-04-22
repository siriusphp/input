<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;

class Checkbox extends BaseInput
{
    /**
     * Value of the hidden input field
     */
    const DEFAULT_VALUE = 'default_value';

    /**
     * Value of the checkbox
     */
    const CHECKED_VALUE = 'checked_value';

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'checkbox'
        );
    }
}
