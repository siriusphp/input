---
title: Validating incoming data
---

# Validating incoming data

The **Sirius\Input** library uses the [Sirius\Validation](http://www.sirius.ro/php/sirius/validation) library.

The `Specs::VALIDATION_RULES` (ie: `validation_rules`) spec of an element is an array of validation rules. Each validation rule requires 3 parameters

- name of the rule
- options for the rule (optional)
- error message template (optional, defaults to the rule's messages)

These are the parameters required by the `Sirius\Validation\Validator::add()` method and they must be provided in a format that is recognizable by that library.

```php
$form->add('name', array(
    'label' => 'Name'
	'validation_rules' => array(
		// simple rule that uses the default error message
		'required',
		// validation rule with options and custom error message
		// the {label} placeholder will be replaced with the label attribute
		array('minlength', ['min' => 20], '{label} must have at least {min} characters'),
		// validation rule with options provided as a URL QUERY string
		array('maxlength', 'max=200', 'Field must have less than {max} characters')
	),
));

```

Input validation rules are attached to the form's validator object during the preparation of the form. Until then you are free to change the validation rules attached to the input.

[Learn more about Sirius\Validation](http://www.sirius.ro/php/sirius/validation).


## Adding/changing/removing validation rules

While this is not a usual scenario, you can alter the validation rules of an input element (via plugins/events) 

```php
$rules = $form->getElement('date')->getValidationRules(); // this is an array
// remove a rule
unset($rules[0]);
// add a rule
$rules[] = 'required';

// then you have to pass it back
$form->getElement('date')->setValidationRules($rules);
```

**Important!** The `Sirius\Validation` library allows you to send the validation rules using different formats (eg: a string instead of an array) so the code above may not work