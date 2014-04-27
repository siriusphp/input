# Creating a form

Once you have your dependencies in place creating forms is as easy as:


```php
$form = new Form($elementFactory, $validator, $filtrator);
```

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

You can extend the **Sirius\Forms** forms for your application

```php
class MyForm extends \Sirius\Forms\Form
{
    function init()
    {
        // here you can do stuff specific to your form like adding elements
        // or adding specific attributes to the form (classes, data attributes etc)
    }
}
```
