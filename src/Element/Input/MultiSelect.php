<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Specs;

class MultiSelect extends Select
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET     => 'multiselect',
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
    public function filterValue($value, $valueIdentifier = null)
    {
        if (!$value) {
            return null;
        }
        if (!is_array($value)) {
            $value = (array) $value;
        }
        $allowedValues = array_keys($this->getChoices());

        return array_intersect($value, $allowedValues);
    }
}
