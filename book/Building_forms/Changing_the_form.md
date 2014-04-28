# Changing the form


## Modify the form

The `Form` class extends the `Specs` class (which is an augmented `\ArrayObject`) which allows you to alter the form's properties

```php
$form->setAttribute('method', 'post')
	->setAttribute('action', '/controller/action')
	->addClass('form-inline')
	->removeClass('row');

// or using array object notation if you're more comfortable and you know what you're doing :)

$form->attributes['method'] = 'post';
$form->attributes['class'] = 'form-inline';
```

## Modify form elements

Usually you don't need to do this but if your app uses events (or other mechanism) to alter the forms between their construction and rendering, you need to access the form elements after they are attached to the form.

You can access the form's elements by their name:


```php
$email = $form->get('email');
$email->addClass('full-width');
$email->addLabelClass('required');
$email->setPosition(100);
```

## Remove form elements


```php
$form->remove('email');
```

