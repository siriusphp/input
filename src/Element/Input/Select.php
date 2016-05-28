<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;
use Sirius\Input\Specs;
use Sirius\Filtration\Filter\Callback;
use Sirius\Input\InputFilter;

class Select extends BaseInput
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET => 'select'
        );
    }

    /**
     * Sets the choices for elements like selects, radio buttons, checkboxes
     *
     * @param array $options
     *
     * @return $this
     */
    public function setChoices($options = array())
    {
        $this[Specs::CHOICES] = $options;

        return $this;
    }

    /**
     * Retrieves the choices for selects, radio button, checkboxes
     *
     * @return array
     */
    public function getChoices()
    {
        return isset($this[Specs::CHOICES]) ? $this[Specs::CHOICES] : array();
    }

    /**
     * Sets the first choice for SELECT widgets
     *
     * @param null $firstChoice
     *
     * @return $this
     */
    public function setFirstChoice($firstChoice = null)
    {
        $this[Specs::FIRST_CHOICE] = $firstChoice;

        return $this;
    }

    /**
     * Retrieve the first option for SELECT widgets
     * @return null
     */
    public function getFirstChoice()
    {
        return isset($this[Specs::FIRST_CHOICE]) ? $this[Specs::FIRST_CHOICE] : null;
    }

    protected function prepareFiltrator(InputFilter $input)
    {
        parent::prepareFiltrator($input);
        $filtrator = $input->getFiltrator();
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
    public function filterValue($value, $valueIdentifier = null)
    {
        if (!$value) {
            return null;
        }
        $allowedValues = array_keys($this->getChoices());
        if (is_array($allowedValues) && in_array($value, $allowedValues)) {
            return $value;
        }

        return null;
    }
}
