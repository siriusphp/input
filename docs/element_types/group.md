# Group

Groups are visual containers of elements. They do not contain any data and other elements may be moved in and out of them. Here's how you add them:

```php
$form->addElement('column_1', array(
	Specs::TYPE => 'group',
	Specs::ATTRIBUTES => ['class' => 'col-md-6 col-sm-12']
));
```

In order to specify that an element belongs **visually** to a group you must set its `group` property.

```php
$form->addElement('email', array(
	Specs::TYPE => 'email',
	Specs::LABEL => 'Email address',
	Specs::GROUP => 'column_1'
));
```
