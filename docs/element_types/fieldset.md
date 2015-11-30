# Fieldset

Fieldsets extend the `Input` class and behave similar to a form (ie: you can add children to it). Thus, a fieldset has a value (ie: an array) which will be broken down and passed to its children.

### Add fieldset to form

```php
// construct your fielset in one command
$form->addElement('credentials', array(
	Specs::TYPE => 'fieldset',
	// this MAY be rendered as the LEGEND tag
	Specs::LABEL => 'Credentials',
	Specs::CHILDREN => array(
		'email' => array (
			Specs::ATTRIBUTES => ['type' => 'email']
		),
		'password' => array (
			Specs::WIDGET => ['type' => 'password']
		)
	)
));
```

### Add element to fieldset

```php
// or add the children later
$fieldset = $form->getElement('credentials');

$fielset->addElement('email', array(
	Specs::LABEL => 'Email'
));
```

### Change a fielset element

```php
// alter the fieldset's children any time
$credentialsEmail = $fieldset->getElement('email');
$email->setLabel('Your email');
```

## Fieldsets vs. forms

The difference between a form and a fieldset is that the elements of a fieldset are __"namespaced"__.

If an input named `email` belongs to a form the rendered element will have the `name="email"` attribute but if it belongs to a fieldset named `credentials` it will have `name=credentials[email]`.

**Important!** This will have implications on everything else related to the form (filtration and validation), ie. the validator and filtrator will have rules for the  `credentials[email]` value selector.

## Fieldsets vs. groups

A group is just a visual container for other elements and it doesn't affect the elements it contains while a fieldset affects the elements it contains. You cannot move around elements from a fielset into another fielset but you can move elements from group to group.

A group can contain fieldsets and viceversa.
