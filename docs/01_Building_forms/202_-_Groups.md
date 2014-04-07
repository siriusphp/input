# Groups

Groups are visual containers of elements. You can add it to the form through an array:

```php
$form->add('column_1', array(
	Element::TYPE => 'group',
	Element::ATTRIBUTES => ['class' => 'col-md-6 col-sm-12']
));
```

In order to specify that an element belongs visually to a group you must set its `group` property.

```php
$form->add('email', array(
	Element::TYPE => 'email',
	Element::LABEL => 'Email address',
	Element::GROUP => 'column_1'
));
```
