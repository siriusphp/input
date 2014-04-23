# Add form elements

Form element classes extend the `Sirius\Forms\Element` class and **Sirius\Forms** uses traits to augment them.

Adding elements to a form is as simple as

```php
// provide specs for the element factory
$specs = array(
	Element::TYPE => 'text',
	Element::LABEL => 'Your email address'
);
$form->add('email', $specs);
```

## Element factory

The element factory converts the element's definition (an array) into an element object. The element factory allows you to register new element types. Although the **Sirius\Forms*** library comes already packed with lots of elements you will definetely need your own even if only for reducing the code you write. For example you may define an address fieldset as a generic fieldset with a list of children or extend the generic fieldset to include the children; this way if you need the address fieldset in different forms you can reuse it.

[Learn about the ElementFactory](../10_API/ElementFactory.md)


## Form elements are not widgets

_Ideally_, all the data that a user sends to your app should be in a format that is understandable by the system without any additional preparation. But there are many situations when that is not going to happen

1. You want to allow the user to send localized data (eg: dates, numbers)
2. You want to make it easier to the user to provide data (eg: use day, month and year fields for entering a date or use autocomplete widgets)

**Important!** From **Sirius\Forms**' point of view there is no connection between the type of the element (ie: the value of the `Element::TYPE` attribute) and how that element is rendered to the user (ie: the visual widget).

This means that when you define a form element you must be aware of how it is going to be displayed and add additional properties. In the case of the date input that is displayed as a 3 selects you must:

1. add a filter to convert that array into a string
2. make sure your renderer will be able to extract its data from a string date.

**Sirius\Forms** has only a few basic built-in form elements and you need to create your own fields according to your application's needs. Don't be scared, it's very easy to create custom input fields. Check out the [examples](https://github.com/siriusphp/forms/tree/master/examples) folder to see how to create localized dates, autocomplete elements and much more.

## Element types

The **Sirius\Forms** library contains a few base elements that can be extended for your particular needs. Some of these base elements are already extended by the library to cover anybody's basic needs out-of-the-box.

### 1. Inputs

These are the usual form elements that you use in a form (text fields, textareas, selects etc).

[Learn about input elements](201_-_Input_fields.md)

### 2. Buttons

Buttons are form elements that don't contain data as the rest of the elements do. There is support for simple buttons, submit buttons and reset buttons.

### 3. Groups

These are elements that do not hold data but are visual containers for grouping other elements. If your form is displayed in a grid with 2 column a group is a column. Another use of a group is a being the container for the form's buttons.
Inputs that belong to a group must have their `group` property set as the name of the group.

Groups can contain inputs, groups, fieldsets and collections.

[Learn more about groups](202_-_-_Groups.md)

### 4. Fieldsets

This type of element is designed to have child elements under a namespace. For example you may have an `address` fieldset that contains inputs like `street`, `city` and `country`; the HTML fields in the form will have their `name` attributes created as: `address[street]`, `address[city]` and `address[country]`.

While the library allows you to define a form element of type input with the name `address[street]` which you can visually move to any group, in the case of fieldsets its children cannot be moved outside the fieldset.

A fielset may contain input, groups, fieldsets and collections. You can move an input from a fieldset to a group inside that fieldset but not outside it.

[Learn more about fieldsets](203_-_Fieldsets.md)

### 5. Collections

This is a type of element that contains a repeatable set of elements. An example of such element is the list of invoice lines which may contain input elements such as `product_name`, `quantity` and `price`.

Just like in the case of fieldsets you can move around elements inside a collection but not outside it.

[Learn more about collections](204_-_Collections.md)

