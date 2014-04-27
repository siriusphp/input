# Fieldset

Fieldsets extend the `Input` class and behave similar to a form (ie: you can add children to it).

```php
// construct your fielset in one command
$form->add('credentials', array(
	Element::TYPE => 'fieldset'
	Element::CHILDREN => array(
		'password' => array (
			Element::TYPE => 'password'
		)
	)
));

// or add the children later
$fielset = $form->get('credentials');

$fielset->add('email', array(
	Element::LABEL => 'Email'
));

// alter the fieldset's children any time
$credentialsEmail = $fieldset->get('email');
$email->setLabel('Your email');
```

The difference between a form and a fieldset is that the elements of a fieldset are __"namespaced"__. If an input named `email` belongs to a form the rendered element will have `name="email"` but if it belongs to a fieldset named `credentials` it will have `name=credentials[email]`.

**Important!** This will have implications on everything else related to the form: filtration and validation. The validator might have rules for the selector `credentials[email]` and the filtrator might have filters for the same selector.

**Warning!** There is nothing that prevents you from adding a field with the name `credentials[email]` directly to the form but this behaviour is not well tested.
