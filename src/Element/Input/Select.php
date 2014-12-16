<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;
use Sirius\Forms\Specs;
use Sirius\Filtration\Filter\Callback;
use Sirius\Forms\Form;

class Select extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'select'
        );
    }

    /**
     * Sets the options for elements like selects, radio buttons, checkboxes
     *
     * @param array $options
     *
     * @return $this
     */
    function setOptions($options = array()) {
        $this[Specs::OPTIONS] = $options;
        return $this;
    }

    /**
     * Retrieves the options for selects, radio button, checkboxes
     *
     * @return array
     */
    function getOptions() {
        return isset($this[Specs::OPTIONS]) ? $this[Specs::OPTIONS] : array();
    }

    /**
     * Sets the first option for SELECT widgets
     *
     * @param null $firstOption
     *
     * @return $this
     */
    function setFirstOption($firstOption = null) {
        $this[Specs::FIRST_OPTION] = $firstOption;
        return $this;
    }

    /**
     * Retrieve the first option for SELECT widgets
     * @return null
     */
    function getFirstOption() {
        return isset($this[Specs::FIRST_OPTION]) ? $this[Specs::FIRST_OPTION] : null;
    }

    protected function prepareFormFiltration(Form $form)
    {
        parent::prepareFormFiltration($form);
        $filtrator = $form->getFiltrator();
        $filtrator->add(
            $this->getName(),
            'callback',
            array(
                Callback::OPTION_CALLBACK => array($this, 'filterValue')
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
        if (is_array($allowedValues) && isset($allowedValues[ $value ])) {
            return $value;
        }
        return null;
    }
}
