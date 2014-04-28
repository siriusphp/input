# Button

Buttons are form elements that don't contain data as the rest of the elements do.

### Submit buttons

```php
$form->add('save', array(
    Element::TYPE => 'submit'
    Element::LABEL => 'Save user'
));
```

### Reset buttons

```php
$form->add('reset', array(
    Element::TYPE => 'reset'
    Element::LABEL => 'Reset form'
));
```

### Simple buttons
These are buttons that do not submit/reset the form

```php
$form->add('button', array(
    Element::TYPE => 'button'
    Element::LABEL => 'Show confirmation'
    Element::ATTRIBUTES => array(
        'onclick' => 'showConfirmation()'
    )
));
```
