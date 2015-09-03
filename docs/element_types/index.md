---
title: Input element types
---

# Input element types

Before looking at the form's element types you must understand that **form elements are not widgets!** This means the visual representation of a form element has very little to do with the element as a value holder. A `Select` type of element can be rendered as a `<SELECT>` HTML tag or as a set of radio buttons.

_Ideally_, all the data that a user sends to your app should be in a format that is understandable by the system without any additional preparation. But there are many situations when that is not going to happen

1. You want to allow the user to send localized data (eg: dates, numbers)
2. You want to make it easier for the user to provide data (eg: use day, month and year fields for entering a date or use autocomplete widgets)

**Important!** From **Sirius\Input**' point of view there is little to no connection between the type of the element (ie: the value of the `Specs::TYPE` attribute) and how that element is rendered to the user (ie: the value of the `Specs::WIDGET` attribute). Still, each form element may have default specs that inform the renderer about how the form element is going to be displayed. For example a `textarea` element will have `textarea` as the value for `widget` and will have some defaults for the `cols` and `rows` attributes. You will find more about this on the "[custom  elements](Form_element_types/Custom_elements.md)" selection.

This means that when you define a custom form element you must be aware of the implications and add additional properties. In the case of the date input that is displayed as a 3 selects you must:

1. add a filter to convert that array into a string/date
2. make sure the renderer will be able to extract an array from the string/date.

**Sirius\Input** has only a few basic built-in form elements and you need to create your own fields according to your application's needs. Don't be scared, it's very easy to create custom input fields. Check out the [examples](https://github.com/siriusphp/forms-examples/) repo to see how to create localized dates, autocomplete elements and much more.

The **Sirius\Input** library contains a few base elements that can be extended for your particular needs. Some of these base elements are already extended by the library to cover anybody's basic needs out-of-the-box.

* [Input](input.html)
    * Text
    * Textarea
    * File
    * Checkbox (for a single checkbox)
    * Select (for when a user should choose an option from a list)
    * Multiselect
* [Button](button.html)
    * Submit
    * Reset
    * Button
* [Group](group.html)
* [Fielset](fieldset.html)
* [Collection](collection.html)
