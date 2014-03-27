# Add form elements

Adding elements to a form is as simple as

```php
// provide specs for the element factory
$specs = array(
	Element::TYPE => 'text',
	Element::LABEL => 'Your email address'
);
$form->add('email', $specs);

// or build your own
$element = new Element\Input\Text(array(
	Element::LABEL => 'Your email address'
));
$form->add('email', $element);

```

## Element factory

The element factory converts the element's definition (an array) into an element object. The element factory allows you to register new element types. Although the **Sirius\Forms*** library comes already packed with lots of elements you will definetely need your own even if only for reducing the code you write. For example you may define an address fieldset as a generic fieldset with a list of children or extend the generic fieldset to include the children; this way if you need the address fieldset in different forms you can reuse it.

[Learn about the ElementFactory](250_-_ElementFactory.md)

## Element types

Ther **Sirius\Forms** library contains a few base elements that can be extended for your particular needs. Some of these base elements are already extended by the library to cover anybody's basic needs out-of-the-box.

### 1. Inputs

These are the usual form elements that you use in a form (text fields, textareas, selects, buttons etc). 

[Learn about input elements](201_Input_fields.md)

### 2. Groups

These are elements that do not hold data but are visual containers for grouping other elements. If your form is displayed in a grid with 2 column a group is a column. Another use of a group is a being the container for the form's buttons.
Inputs that belong to a group must have their `group` property set as the name of the group. 

Groups can contain inputs, groups, fieldsets and collections. 

[Learn more about groups](202_-_Groups.md)

### 3. Fieldsets

This type of element is designed to have child elements under a namespace. For example you may have an `address` fieldset that contains inputs like `street`, `city` and `country`; the HTML fields in the form will have their `name` attributes created as: `address[street]`, `address[city]` and `address[country]`.

While the library allows you to define a form element of type input with the name `address[street]` which you can visually move to any group, in the case of fieldsets its children cannot be moved outside the fieldset. 

A fielset may contain input, groups, fieldsets and collections. You can move an input from a fieldset to a group inside that fieldset but not outside it.

[Learn more about fieldsets](203_Fieldsets.md)

### 4. Collections

This is a type of element that contains a repeatable set of elements. An example of such element is the list of invoice lines which may contain input elements such as `product_name`, `quantity` and `price`.

Just like in the case of fielsets you can move around elements inside a collection but not outside it.

[Learn more about fieldsets](204_Collections.md)

