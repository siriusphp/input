#Ideal forms API

```php

$form = new Form(array(
	'filters' => array(
		'trim',
		'Security::xssClean()',
	)
));

// add a fieldset

$form->add('credentials', array(
	'priority' => 0,
	'type' => 'Fieldset',
	'label' => 'Log in details',
));

//add a simple form element
$form->add('email', array(
	'priority' => 0,
	'parent' => 'credentials',
	'widget' => 'Email',
	'attr' => array(
		'class' => 'special',
	),
	'label' => 'Email',
	'rules' => array(
		'required',
		'email',
	),
	'filters' => array(
		'trim'
	)
));