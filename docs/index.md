# Sirius Forms


```php
$form = new \Sirius\Form('order');

// add form elements
$form->add('client_details', array(
	// type of form element that will group, visually other elements
	'type' => 'container',
	
	'widget' => 'fieldset'
));
$form->add('client_id', array(
	// parent container
	'parent' => 'client_details',
	
	// priority, if you want to specify a display order
	'priority' => 1,
	
	// label
	'label' => 'Client',
	'label_attributes' => array('class' => 'label-important'),
	
	// instructions for the user
	'hint' => 'Type a name or an email address. Click on the "Add" button to create a new client',
	'hint_attributes' => array('data-popover' => 'client_hint'),
	
	// container (an HTML element containing the input field, label, error messages etc)
	'container_attributes' => array('class' => 'clearfix'),
	
	// tell the renderer how to display this field
	'widget' => 'autocomplete',
	'attributes' => array('class' => 'size-full'),
	
	// validation rules that are understandable by the Sirius\Validation library
	'validation' => array('required', 'integer', '\MyApp\Shop\Validators\ClientId'),
	
	// filter rules that are understandable by the Sirius\Filtration library
	'filters' => array('trim', 'nullify', 'integer');
));


$formRenderer = new Sirius\Renderer\Default();
$formRenderer->render($form);
```