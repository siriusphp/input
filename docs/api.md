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
	'type' => 'Group',
	'widget' => 'Fieldset',
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

$renderer = new Sirius\Forms\Renderer\Bootstrap;
$renderer->registerWidget('button', `MyApp\Forms\Widget\Button');
$renderer->registerWidget('autocomplete', `MyApp\Forms\Widget\Autocomplete');

$viewHelper = $renderer->getFormHelper();

$renderer->registerDecorator('translator', $translator);
$renderer->registerDecorator('clientSideValidator', $clientSideValidator);
$renderer->registerDecorator('required', $requiredDecorator);

echo $renderer->renderForm($form);


// in case you don't like how items are rendered
echo $renderer->renderElement($form->getElement('name'));
echo $renderer->renderElement($form->getElement('credentials'));
echo $renderer->renderControl($form->getElement('name'));
echo $renderer->renderWidget('textarea', $specs);

echo $viewHelper->label($text, $attrs);
echo $viewHelper->hint($text, $attrs);
echo $viewHelper->error($error, $attrs);
echo $viewHelper->input($name, $value, $attrs);
echo $viewHelper->textarea($name, $value, $attrs);
echo $viewHelper->textarea($name, $value, $attrs);
