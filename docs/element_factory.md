---
title: The input element factory
---

# The input element factory

A **Sirius\Input** form depends on the element factory which allows you to add elements to form, fieldsets and collections as specifications.

The element factory will use the `Specs::TYPE` (ie: `type`) value of the specs to construct the element and will default to an input text if there is no value.

By default, the element factory can create [enough elements types](Form_element_types.md) to cover most use-cases but you will find yourself needing to create custom element types.

In order for the element factory to be able to create custom elements you have to register them within the factory.

```php
// first you need to get a hold of the element factory instance
// which you can do before creating the form
$elementFactory = new \Sirius\Input\Element\Factory;
$input = new \Sirius\Input\Input($elementFactory);
```

It is recommended to use a single element factory for all of your application's forms. This way you will have to register form elements only once per application. If you use dependency injection that will be trivial.

Element types are useful when you need to define complex form elements (ex: an address fieldset has a street input, a country, a city and a zipcode) or when you want to attach specific behaviour to a form element (ex: add an email validation rule to an `email` element).

**There are 2 ways to register a form element type to the element factory:**

1. As a class (the factory will instantiate the class to create the element)
2. As a callable (the factory will execute the callable to retrieve the element)

## Register an element type as a class

Within the element factory instance you can register a class to be used for creating element instances

```php
$elementFactory->registerElementType('address', 'MyApp\Input\Element\AddressFieldset');

// later in your forms you can do
$form->addElement('shipping_address', array(
    // this tells the element factory what type of element
    // to create for the 'shipping_address'
    Specs::TYPE => 'address'
));
```

The class must extend the `\Sirius\Input\Element` class, or the factory will throw an exception.

## Register an element type as a callable

If the element type you want to create requires more work than just calling `new` on a class you can add a closure

```php
function createUserSelect() {
    // some complex procedure that returns an instance of \Sirius\Input\Element
}
$elementFactory->registerElementType('user_select', 'createUserSelect');

$form->addElement('recipient', array(
    Specs::TYPE => 'user_select'
));
```

## But you are not forced to use the element factory

If you don't want to use the element factory to register your custom elements you can use the class as the `type` of the element

```php
$form->addElement('address', array(
    Specs::TYPE => 'MyApp\Input\Element\Address'
));
```

The element factory class is there so your app can be flexible and allow you to swap element types. If your app has autocomplete-type elements for which you use `MyApp\Input\Element\Autocomplete` as their `type` and you want to change it to `SomePlugin\Input\Element\Autocomplete` it will be difficult to make that change everywhere in your app. In this case, using the element factory is a better approach.
