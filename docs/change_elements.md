---
title: Changing the form
---

# Changing the form

After you have built the structure of your forms (or input objects) you may want to allow other parts of your app (events, plugins etc) to modify them (eg: add view layer instructions, add CSRF protection etc)

## Modify the form

The `Input` class extends the `Specs` class which allows you to alter the form's properties (see the [list of available specs](The_list_of_available_specs.md) for details)

```php
$form
    ->setAttribute('method', 'post')
	->setAttribute('action', '/controller/action')
	->addClass('form-inline')
	->removeClass('row');
```

## Modify form elements

Usually you don't need to do this but you can to access the form elements after they are attached to the form.

You can access the form's elements by their name:

```php
$email = $form->getElement('email');
$email
    ->addClass('full-width');
    ->addLabelClass('required');
    ->setPosition(100);
```

You can also remove a form element if you want.

```php
$form->removeElement('email');
```

Check out the [specs list](specs_list.html) to see the methods available for making such changes.