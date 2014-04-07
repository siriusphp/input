# Groups

Groups are visual containers of elements. You can add it to the form through an array:

```php
$form->add('column_1', array(
	Element::TYPE => 'group',
	Element::ATTRIBUTES => ['class' => 'col-md-6 col-sm-12']
));
```
or you can instantiate it first

```php
$group = new Element\Group(array(
	Element::TYPE => 'group',
	Element::ATTRIBUTES => ['class' => 'col-md-6 col-sm-12']
));
$form->add('column_1', $group);

In order to specify that an element belongs visually to a group you must set its `group` property.

```php
$form->add('email', array(
	Element::TYPE => 'email',
	Element::LABEL => 'Email address',
	Element::GROUP => 'column_1'
));
```
