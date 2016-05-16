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
	    
	    // provide the name of the rule
		'required',         
		
		// provide the full configuration of the validation rule
		array(
		    'minlength',        // name of the rule
		    ['min' => 20],      // options for the rule
		    '{label} must have at least {min} characters'), // error message
        )
        
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

You may take advantage of  [`Sirius\Validation\Validator::add()` syntactic-sugar ](http://www.sirius.ro/php/sirius/validation/syntactic_sugar.html)