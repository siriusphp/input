# Sirius\Form\Element

A form contains elements which extend the `Sirius\Form\Element\Specs` class. Unlike other libraries that handle forms, the elements of **Sirius\Forms** library are nothing more than the specifications of that element and they are not an independent object that may work by itself. You never need only one form element so there is no point in trying to make form elements work independently.

Ideally when constructing a form you want to:

1. define your forms through a configuration (like an array) so you don't have to call a ton of getters and setters
2. be able to programatically alter the form and its element

This is the reason **Sirius\Forms** allows you to do

```php
// although the second parameter can be an instance of an element
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

when initializing the form and

```php
$form->get('email')->setLabel('Email address');
```

anytime after the initalization of the form (eg: if your app uses events to alter the objects in the app).

## Form element specs list

Although your app can impelement form element types that have their own specs there are some common attributes/properties a form element has.
The list below contains the specs that are used by the library during the build process, validation and rendering of the form.

The format of the list contains the key of the specs in the definition array, its associated constant (in order help your IDE help you) and its corresponding getter/setter (in paranthesis).

##### element_type | Element::ELEMENT_TYPE 
    This is required only by the ElementFactory to determine the type of element to be instantiated (defaults to 'text')

#####  attributes | Element::ATTRIBUTES (getAttributes/setAttributes, getAttribute/setAttribute)
    The HTML attributes of the input field

#####  label | Element::LABEL (getLabel/setLabel)
    The label of the input field

#####  label_attributes | Element::LABEL_ATTRIBUTES (getLabelAttributes/setLabelAttributes , getLabelAttribute/setLabelAttributes)
    The HTML attributes of the label element

#####  hint | Element::HINT (getHint/setHint)
    Information text to help the user fill out the form

#####  hint_attributes | Element::HINT_ATTRIBUTES (getHintAttributes/setHintAttributes , getHintAttribute/setHintAttribute) 
    The HTML attributes of the hint element

#####  priority | Element::PRIORITY (getPriority/setPriority) 
    The display order of the form element. This allows decouples the element definition order in time from its order in the rendered form

#####  group | Element::GROUP (getGroup/setGroup)
    Sometimes you want to visually group certain elements. The value of this attribute is the name of the element that will group other elements

##### widget | Element::WIDGET
    This is will instruct the renderer to display the form element in a certain way. You may choose to display a date as a single field or a group of selects, there is no need to tie the form element type to its visual representation

##### validation_rules | Element::VALIDATION_RULES (getValidationRules/setValidationRules)
    Contains an array of validation rules in a format that is understandable by the Validator object 

##### filters | Element::FILTERS (getFilters/setFilters)
    Contains an array of filters to be applied to incoming data in a format that is undestandable by the filtrator object

##### upload_container | Element::UPLOAD_CONATAINER (getUploadContainer/setUploadContainer)
    The upload container (something that is an acceptable parameter by the upload handler library)

##### upload_options | Element::UPLOAD_OPTIONS (getUploadOptions/setUploadOptions)
    Configuration options for the upload handler

#####  upload_rules | Element::UPLOAD_RULES (getUploadRules/setUploadRules)
    Validation rules for the file uploads

##### options | Element::OPTIONS (getOptions/setOptions) 
    A set of options to be used by SELECT elements, checkbox/radio groups

##### first_option | Element::FIRST_OPTION (getFirstOption/setFirstOption) 
    The empty option to be displayed in the list (eg: 'select from list...')

### Special element specs

As you can see from the above list there are some properties of an element which get 2 getters and 2 setters. The `attributes` and any property that have ends with `_attributes` will get this special behaviour. This allows you to do something like:

```php
// get the class attribute of the input field
$cssClass = $form->get('email')->getAttribute('class');
// set a custom attribute for the label
$form->get('email')->setLabelAttribute('data-custom-attribute', 'value');
```

Besides this nice utility there are 3 more methods that can be used to alter the element specs

- `addXXXClass()` - example: `addClass()`, `addLabelClass()`, `addHintClass()`
- `removeXXXClass()` - example: `removeClass()`, `removeLabelClass()`, `removeHintClass()`
- `toggleXXXClass()` - example: `toggleClass()`, `toggleLabelClass()`, `toggleHintClass()`

These magic methods are also available to any property that ends with `_attributes`

### Custom element specs

You can set any other properties to an element and you will get access to a getter and a setter. If your custom render engine can interpret an attribute like `autocomplete_url` the Sirius\Forms library will construct the element which will have the `getAutocompleteUrl()` and `setAutocompleteUrl()` methods.
