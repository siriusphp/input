---
title: Form creation
---

# Dependencies for Input instances

A **Sirius\Input\InputFilter** object has a few dependencies

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

To reduce the verbosity of this you should use dependency injection

# Extend the forms

For each form you need to specify its structure (children) so it is a best practice to create your own classes (for reuse, to not fill your controllers with form specs, for testing etc)

```php
class LoginForm extends \Sirius\Input\InputFilter {
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
