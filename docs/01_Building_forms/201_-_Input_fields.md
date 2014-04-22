# Input fields

Input field classes extend the [Input](../10_API/Input.md) class. Visit the previous link to get an idea of interface of the `Input` class.

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

## Input traits

The traits added to inputs are:

- `HasLabelTrait` for managing the input's label
- `HasHintTrait` for managing the input completion instructions
- `HasValidationRulesTrait` for managing the input's validation rules
- `HasFiltersTrait` for managing the data filters attached to the input
- `HasUploadTrait` for fields that allow uploading files
- `HasChildreTrait` for fields that may contain children (used by forms, fieldsets and collections)

## Built-in input fields

The **Sirius\Forms** library comes packed with a variaty of input fields the cover most of the use-cases:

1. Text
2. Textarea - a text input displayed as a textarea
3. Checkbox - an element that will have a specific value if the user choose to select it
4. File - an element that has the upload trait
5. Select - an element that has a list of valid choices from which only one can be chosen
6. Multiselect - an element that has a list of valid choice from which one or more can be chosen

They diverge very little from the base **Element\Input** class so, by looking at their code, you'll be able to understand what it takes to create your own custom fields.

**Reminder!** The type of form elements have little to do how they are displayed. The renderer is responsible for the visual representation of the form and its elements.