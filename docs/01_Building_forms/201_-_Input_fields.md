# Input fields

Input fields extend the [Element](../10_API/Element.md) class. You're advised to take a look at the previous like to get an idea of interface. 

This is how you add an element to a form (you do the same for fieldsets and collections).

```php
// the code below relies on the element factory to instanciate the element
$form->add('email', array(
    'label' => 'Your email'
	'hint' => 'We will send you an account activation email after registration',
	'rules' => array(
		'required',
		'email'
	),
	'filters' => array(
		'stringtrim'
	)
));
```
You can get hold of the element like so:

```php
$email = $form->get('email');

// and alter it through the build it methods
$email->setLabel('Email address')
	->addLabelClass('important');

// or as an ArrayObject
$email->label = 'Your email';
$email['label_attributes']['class'] = 'important';
```


## Built-in input fields

The **Sirius\Forms** library comes packed with a variaty of input fields the cover most of the use-cases:

1. Text
2. Textarea
3. Checkbox
4. CheckboxSet
5. Radio
6. RadioSet
7. Select
8. File
9. Password
10. Email
11. DateTime
12. LocalDateTime
13. Number

They diverge very little from the base **Element\Input** class so, by looking at their code you'll be able to understand what it takes to create your own custom fields.

**Note!** The type of form elements have little to do how they are displayed. The renderer must be able to handle each type, otherwise they will render a text field. Creating custom elements solves only 20% of the problem (rendering is 80%)