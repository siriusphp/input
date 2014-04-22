<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;
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
