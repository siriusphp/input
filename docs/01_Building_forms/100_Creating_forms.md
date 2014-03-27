# Creating forms

A **Sirius\Forms** form has a few dependencies

1. the element factory
2. the validator object
3. the filtrator object

These dependencies have default values that allow you to start building forms ASAP. The downside is that you are bound to the default functionality. For example if you have custom validation rules you won't be able to use it because the validator object dependends on a `RuleFactory` where you must register your custom validation rules.

```php
use Sirius\Forms\Form;
use Sirius\Forms\ElementFactory;
use Sirius\Validation\Validator;
use Sirius\Filtration\Filtrator;

$elementFactory = new ElementFactory();
$validator = new Validator();
$filtrator = new Filtrator();

$form = new Form($elementFactory, $validator, $filtrator);
```

The `Form` class extends the `Element\Specs` (which is an augmented `\ArrayObject`) class which allows you to alter the form's properties

```php
$form->setAttribute('method', 'post')
	->setAttribute('action', '/uri')
	->addClass('form-inline')
	->removeClass('row')

// or using array object notation

$form->attributes['method'] = 'post';
$form->attributes['class'] = 'form-inline';
```

That's all you need to contruct your form. Next step: [start adding elements](02_Add_elements_to_your_form.md)
