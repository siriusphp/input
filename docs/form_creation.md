---
title: Form creation
---

# Dependencies for Input instances

A **Sirius\Input\Input** object has a few dependencies

1. the [element factory](Building_forms/Element_factory.md) which will construct `Sirius\Input\Element` objects based on the specifications (a simple array) you provide
2. the validator object which will be used to validate the values provided to the form
3. the filtrator object which will be used to filtrate the data sent to the form

```php
use Sirius\Input\InputFilter;
use Sirius\Input\Element\Factory as ElementFactory;
use Sirius\Validation\Validator;
use Sirius\Filtration\Filtrator;

$elementFactory = new ElementFactory();
$validator = new Validator();
$filtrator = new Filtrator();

$form = new InputFilter($elementFactory, $validator, $filtrator);
```

All of the form's dependencies above have default values so you may choose not to specify them. Usually your app will have custom form element types (eg: autocomplete, datepickers etc), custom validation rules and filters.
This means that the app will use a single `ElementFactory` for all forms. The `$validator` object depends on a "rule factory" which most likely must be an object shared by all validators. And so on.

Still, the other Sirius libraries are flexible enough to let you get away with this. Like so

```php
// add a custom validator at any time
$userForm->addElement('email', array(
    Specs::TYPE => 'MyApp\Input\Element\EmailPicker' // this is a class
    //
    //  element details (label, attributes etc) go here
    //
    Specs::VALIDATION_RULES => ['required', 'MyApp\Validators\UniqueUserEmail']
    Specs::FILTERS => ['stringtrim', 'MyApp\Filters\XSS']
));
```

From some point of view this might seem a better approach because you can see where you can find those custom implementations.

# Extend the forms

For each form you need to specify its structure (children) so it is a best practice to create your own classes (for reuse, to not fill your controllers with form specs, for testing etc)

```php
class LoginForm extends \Sirius\Input\Input {
    function init() {
        parent::init();

        // here you can do stuff specific to your form like adding elements
        // or adding specific attributes to the form (CSS classes, HTML attributes etc)
        // either directly or through some event-based system

        $this->addElement('username', $usernameSpecs);
        $this->addElement('password', $passwordSpecs);
        $this->addElement('remember_me', $rememberMeSpecs);
    }
}
```

This way all you have to do in your app code is:

```php
$loginForm = new LoginForm();
```
