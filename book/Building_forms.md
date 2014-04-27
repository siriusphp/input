# Building forms

A **Sirius\Forms** form has a few dependencies

1. the element factory which will construct `Sirius\Forms\Element` objects based on the specifications you provide
2. the validator object which will be used to validate the values provided to the form
3. the filtrator object which will be used to filtrate the data sent to the form

These dependencies have default values that allow you to start building forms ASAP.

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

All of the form's depedencies above have default values so you may choose not to use them but the downside is that you are bound to the default functionality. For example:

* if you have custom validation rules you won't be able to use it because the validator object dependends on a `RuleFactory` where you must register your custom validation rules.
* if your app's forms have custom element types they must be registered in the `ElementFactory` instance


Some of these problems are not a deal-breaker because you can do stuff like

```php
// add a custom validator at any time
$form->getValidator()->getRuleFactory()->register('my_email_validator', 'MyApp\Validator\Email`);

// add a custom element type
$form->getElementFactory()->registerElementType('custom_element', 'MyApp\Forms\Element\Custom');

```

but that is not good practice because these means you will repeat yourself and you'll define your dependencies inside the application code.
