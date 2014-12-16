<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Form;
use Sirius\Forms\Specs;
use Sirius\Forms\Element\Input\Select;
use Sirius\Filtration\Filter\Callback;

class MultiSelect extends Select
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET => 'multiselect',
            Specs::ATTRIBUTES => array(
                'size' => '5'
            )
        );
    }

    /**
     * Filters out the input value if it is not in the options set
     *
     * @param mixed $value
     * @param null|string $valueIdentifier
     *
     * @return mixed
     */
    function filterValue($value, $valueIdentifier = null)
    {
        $allowedValues = $this->getOptions();
        if (is_array($allowedValues) && isset($allowedValues[$value])) {
            return $value;
        }
        return null;
    }
}
