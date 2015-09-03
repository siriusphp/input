<?php
namespace Sirius\Input\Traits;

use Sirius\Input\Specs;
use Sirius\Input\InputFilter;

trait HasValidationRulesTrait
{

    /**
     * Get the element value validation rules
     *
     * @return array
     */
    function getValidationRules()
    {
        return isset($this[Specs::VALIDATION_RULES]) ? $this[Specs::VALIDATION_RULES] : array();
    }

    /**
     * Set the element value validation rules
     *
     * @param array $rules            
     *
     * @return $this
     */
    function setValidationRules($rules = array())
    {
        $this[Specs::VALIDATION_RULES] = $rules;
        return $this;
    }

    /**
     * Adds the element's validation rules to the validator object
     *
     * @param InputFilter $input
     *
     * @throws \InvalidArgumentException
     */
    protected function prepareValidator(InputFilter $input)
    {
        $validationRules = $this->getValidationRules();
        if (! $validationRules || ! is_array($validationRules)) {
            return;
        }
        $validator = $input->getValidator();
        foreach ($validationRules as $rule) {
            $params = is_array($rule) ? $rule : array(
                $rule
            );
            if (isset($params[0])) {
                $validator->add($this->getName(), $params[0], @$params[1], @$params[2], $this->getLabel());
            }
        }
    }
}
