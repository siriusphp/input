# Adding elements to forms

Adding elements to a form is as simple as telling the form the name of the element (so it can later be retrieved) and the element' specifications:

```php
use Sirius\Forms\Element;

// provide specs for the element factory
$specs = array(
	Element::TYPE => 'text',
	Element::LABEL => 'Your email address'
);
$form->add('email', $specs);
```

The `Element` class has a lot of constats that you can use when definining the element specifications.

When you add an element to the form the `ElementFactory` converts the specifications into an `Element` object that you can manipulate.

```php
$email = $form->get('email');
$email->addClass('full-width');
$email->addLabelClass('required');

```

Usually you don't need to do this but if your app uses events (or other mechanism) to alter the forms between their construction and rendering, this is the way to go.

## The `Element` specs and API

The list below contains the specs that are used by the library during the build process, validation and rendering of the form.

The format of the list contains the key of the specs in the definition array, its associated constant (in order help your IDE help you) and its corresponding getter/setter (in paranthesis).

##### `type` | Element::TYPE

This is required only by the ElementFactory to determine the type of element to be instantiated (defaults to 'text').

**Important!** You can change it at any time but that will not change the already instanciated element.

#####  `attributes` | Element::ATTRIBUTES (getAttributes/setAttributes, getAttribute/setAttribute)

The HTML attributes of the input field. Example:

```php
$email = $form->getEmail();
$email->setAttributes(array(
    'class' => 'required email'
    'type' => 'email'
));
$attrs = $email->getAttributes();

$email->setAttribute('class', 'required email');
$email->getAttribute('class');
```

#####  `label` | Element::LABEL (getLabel/setLabel)

The label of the input field. Example:

```php
$email->setLabel('Your email');
$email->getLabel(); // Your email
```

#####  `label_attributes` | Element::LABEL_ATTRIBUTES (getLabelAttributes/setLabelAttributes , getLabelAttribute/setLabelAttributes)

The HTML attributes of the label element

#####  `hint` | Element::HINT (getHint/setHint)

Information text to help the user fill out the form

#####  `hint_attributes` | Element::HINT_ATTRIBUTES (getHintAttributes/setHintAttributes , getHintAttribute/setHintAttribute)

The HTML attributes of the hint element

#####  `position` | Element::POSITION (getPosition/setPosition)

The display order of the form element. This allows decouples the element definition order in time from its order in the rendered form. The default priority is zero. The elements of a form/fieldse/collection/group will be ordered ascending by position.

#####  `group` | Element::GROUP (getGroup/setGroup)

Sometimes you want to visually group certain elements. The value of this attribute is the name of the element that will group other elements

##### `widget` | Element::WIDGET

This is will instruct the renderer how to display the form element (the type of widget the widget factory will compose). You may choose to display a date as a single field or a group of selects, there is no need to tie the form element type to its visual representation

##### `validation_rules` | Element::VALIDATION_RULES (getValidationRules/setValidationRules)

Contains an array of validation rules in a format that is understandable by the Validator object

##### `filters` | Element::FILTERS (getFilters/setFilters)

Contains an array of filters to be applied to incoming data in a format that is undestandable by the filtrator object

##### `upload_container` | Element::UPLOAD_CONATAINER (getUploadContainer/setUploadContainer)

The upload container (something that is an acceptable parameter by the upload handler library)

##### `upload_options` | Element::UPLOAD_OPTIONS (getUploadOptions/setUploadOptions)

Configuration options for the upload handler

##### `upload_rules` | Element::UPLOAD_RULES (getUploadRules/setUploadRules)

Validation rules for the file uploads

##### `options` | Element::OPTIONS (getOptions/setOptions)

A set of options to be used by SELECT elements, checkbox/radio groups

##### `first_option` | Element::FIRST_OPTION (getFirstOption/setFirstOption)

The empty option to be displayed in the list (eg: 'select from list...')

#### `data` | Element::DATA (getData/setData)

Similarly to jQuery you can add random data to your elements.

```php
$email->setData(array(
    'multiple items' => true,
    'set in one go' => true
));
$email->setData('key', 'value')
$email->getData('key'); //value
$email->getData(); // get everything
```

### Other magic methods

As you can see from the above list there are some properties of an element which get 2 getters and 2 setters. The `attributes` and any property that ends with `_attributes` will get this special behaviour. This allows you to do something like:

```php
// get the class attribute of the input field
$cssClass = $form->get('email')->getAttribute('class');
// set a custom attribute for the label
$form->get('email')->setLabelAttribute('data-custom-attribute', 'value');
```

Besides these nice utilities there are 3 more methods that can be used to alter the element specs

- `addXXXClass()` - example: `addClass()`, `addLabelClass()`, `addHintClass()`
- `removeXXXClass()` - example: `removeClass()`, `removeLabelClass()`, `removeHintClass()`
- `toggleXXXClass()` - example: `toggleClass()`, `toggleLabelClass()`, `toggleHintClass()`

These magic methods are also available to any property that ends with `_attributes`.

### Custom element specs

You can set any other properties to an element and you will get access to a getter and a setter. If your custom render engine can interpret an attribute like `autocomplete_url` the Sirius\Forms library will construct the element which will have the `getAutocompleteUrl()` and `setAutocompleteUrl()` methods.

These custom specification will be added to the `data` container.

```php
$element->setAutoCompleteUrl('controller/action.json');
// is the same as
$element->setData('auto_complete_url', 'controller/action.json');
```

**Note!** Unless you define these methods on your custom elements, you don't get IDE support.
