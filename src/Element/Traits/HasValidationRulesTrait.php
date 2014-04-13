<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;
use Sirius\Forms\Form;

trait HasValidationRulesTrait {

    function getValidationRules() {
        return isset($this[Input::VALIDATION_RULES]) ? $this[Input::VALIDATION_RULES] : array();
    }

    function setValidationRules($rules = array()) {
        $this[Input::VALIDATION_RULES] = $rules;
        return $this;
    }

    protected function prepareFormValidation(Form $form)
    {
        $validationRules = $this->getValidationRules();
        if (!$validationRules || !is_array($validationRules)) {
            return;
        }
        $validator = $form->getValidator();
        foreach ($validationRules as $rule) {
            $params = is_array($rule) ? $rule : array($rule);
            if (isset($params[0])) {
                $validator->add($this->getName(), $params[0], @$params[1], @$params[2], $this->getLabel());
            }
        }

    }

}
