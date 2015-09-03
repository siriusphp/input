---
title: The list of input specs
---

# The list of available specs

The list below contains the specs that are used by the library during the build process, validation and rendering of the form.

**Important!** The `Input` class extends from the `Element` class so, some of the methods below work on forms too. For example, form can have filters, but not validation rules.

The format of the list contains:

1. the key of the specs in the definition array
2. the constant associated with that key (in order to help your IDE help you)
3. the corresponding getter/setter methods that can be used to alter the elements (the getters/setters are usefull if you have some kind of plugin architecture that allows other components to modify the content of a form; otherwise just setting the values for the specs will be enough).

##### `type` | Specs::TYPE

This is required only by the ElementFactory to determine the type of element to be instantiated (defaults to 'text').

#####  `attributes` | Specs::ATTRIBUTES | getAttributes()/setAttributes(), getAttribute()/setAttribute()

The HTML attributes of the input field. Example:

```php
$email = $form->getElement('email');
$email->setAttributes(array(
    'class' => 'required email'
    'type' => 'email'
));
$attrs = $email->getAttributes();

$email->setAttribute('class', 'required email');
$email->getAttribute('class');
```

#####  `label` | Specs::LABEL | getLabel()/setLabel()

The label of the input field. Example:

```php
$email->setLabel('Your email');
$email->getLabel(); // Your email
```

#####  `label_attributes` | Specs::LABEL_ATTRIBUTES | getLabelAttributes()/setLabelAttributes() , getLabelAttributes()/setLabelAttributes(), getLabelAttribute()/setLabelAttribute()

The HTML attributes of the label element

#####  `hint` | Specs::HINT | getHint()/setHint()

Information text to help the user fill out the form

#####  `hint_attributes` | Specs::HINT_ATTRIBUTES | getHintAttributes()/setHintAttributes(), getHintAttribute()/setHintAttribute()

The HTML attributes of the hint element

#####  `position` | Specs::POSITION | getPosition()/setPosition()

The display order of the form element. This allows decouples the element inclusion order  time from its visual position in the rendered form. The default priority is zero. The elements of a form/fieldse/collection/group will be ordered ascending by position.

#####  `group` | Specs::GROUP | getGroup()/setGroup()

Sometimes you want to visually group certain elements. The value of this attribute is the name of the element that will group other elements.

```php
$form->getElement('email')->setGroup('credentials');
$form->getElement('password')->setGroup('credentials');
```

##### `widget` | Specs::WIDGET | setWidget()/getWidget()

This is will instruct the renderer how to display the form element (the type of widget the widget factory will compose). You may choose to display a date as a single field or a group of selects, there is no need to tie the form element type to its visual representation. Anything can go here (text, textarea, htmlarea, autocomplete, jquery_datepicker) as long as the form renderer will make sense of it.

##### `validation_rules` | Specs::VALIDATION_RULES | getValidationRules()/setValidationRules()

Contains an array of validation rules in a format that is understandable by the Validator object

##### `filters` | Specs::FILTERS | getFilters()/setFilters()

Contains an array of filters to be applied to incoming data in a format that is undestandable by the filtrator object

##### `upload_container` | Specs::UPLOAD_CONTAINER | getUploadContainer()/setUploadContainer()

The upload container (something that is an acceptable parameter by the upload handler library)

##### `upload_options` | Specs::UPLOAD_OPTIONS | getUploadOptions()/setUploadOptions()

Configuration options for the upload handler

##### `upload_rules` | Specs::UPLOAD_RULES | getUploadRules()/setUploadRules()

Validation rules for the file uploads

##### `options` | Specs::OPTIONS | getOptions()/setOptions()

A set of options to be used by SELECT and MULTISELECT type of elements (these can be rendered as dropdowns or sets of checkboxes/radio buttons)

##### `first_option` | Specs::FIRST_OPTION | getFirstOption()/setFirstOption()

The empty option to be displayed in the dropdown (eg: 'select from list...')

##### `data` | Specs::DATA | getData()/setData()

Similarly to jQuery you can attach random data to your elements.

```php
$email->setData(array(
    'multiple items' => true,
    'set in one go' => true
));
$email->setData('key', 'value')
$email->getData('key'); //value
$email->getData(); // get everything
```

This can be used to further add instructions for the view layer.

## Other magic methods

As you can see from the above list there are some specs of an element which get 2 getters and 2 setters. They end with `attributes` and have this special behaviour:

```php
// get the class attribute of the input field
$cssClass = $form->get('email')->getAttribute('class');
// set a custom attribute for the label
$form->get('email')->setLabelAttribute('data-custom-attribute', 'value');
```

Besides these nice utilities there are 3 more methods that can be used to alter the element specs

- `add***Class()` - example: `addClass()`, `addLabelClass()`, `addHintClass()`
- `remove***Class()` - example: `removeClass()`, `removeLabelClass()`, `removeHintClass()`
- `toggle***Class()` - example: `toggleClass()`, `toggleLabelClass()`, `toggleHintClass()`

