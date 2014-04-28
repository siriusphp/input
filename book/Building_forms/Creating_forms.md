# Creating a form

Once you have your dependencies in place creating forms is as easy as:


```php
$form = new Form($elementFactory, $validator, $filtrator);
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
