# Form element types

Before looking at the form's element types you must understand that **form elements are not widgets!**

_Ideally_, all the data that a user sends to your app should be in a format that is understandable by the system without any additional preparation. But there are many situations when that is not going to happen

1. You want to allow the user to send localized data (eg: dates, numbers)
2. You want to make it easier to the user to provide data (eg: use day, month and year fields for entering a date or use autocomplete widgets)

**Important!** From **Sirius\Forms**' point of view there is no connection between the type of the element (ie: the value of the `Element::TYPE` attribute) and how that element is rendered to the user (ie: the value of the `Element::WIDGET` attribute).

This means that when you define a form element you must be aware of how it is going to be displayed and add additional properties.

In the case of the date input that is displayed as a 3 selects you must:

1. add a filter to convert that array into a string
2. make sure your renderer will be able to extract construct an array from the string date.

**Sirius\Forms** has only a few basic built-in form elements and you need to create your own fields according to your application's needs. Don't be scared, it's very easy to create custom input fields. Check out the [examples](https://github.com/siriusphp/forms/tree/master/examples) folder to see how to create localized dates, autocomplete elements and much more.

The **Sirius\Forms** library contains a few base elements that can be extended for your particular needs. Some of these base elements are already extended by the library to cover anybody's basic needs out-of-the-box.

* [Input](Form_element_types/Input.md)
* [Button](Form_element_types/Button.md)
* [Group](Form_element_types/Group.md)
* [Fielset](Form_element_types/Fielset.md)
* [Collection](Form_element_types/Collection.md)
