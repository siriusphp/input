# Validation

The **Sirius\Forms** library uses the [Sirius\Validation](http://github.com/siriusphp/validation) library.

The `validation_rules` property of an input specs is an array of validation rules. For each validation rule 3 parameters are needed

- name of the rule
- options for the rule (optional)
- error message template (optional)

These are the parameters required by the `Sirius\Validation\Validator::add()` method and they can be provided in a format that is recognizable by that library.

```php
$form->add('name', array(
    'label' => 'Name'
	'validation_rules' => array(
		// simple rule that uses the default error message
		'required',
		// normal definition of validation rule
		array('minlength', ['min' => 20], '{label} must have at least {min} characters'),
		// validation options as a QUERY string
		array('maxlength', 'max=200', 'Field must have less than {max} characters')
	),
));

```

Input validation rules are attached to the form's validator object during the preparation of the form. Until then you are free to change the validation rules attached to the input.

[Learn more about Sirius\Validation](http://github.com/siriusphp/validation).
