# Button

Buttons are form elements that don't contain data as the rest of the elements do.

### Submit buttons

```php
$form->addElement('save', array(
    Specs::TYPE => 'submit'
    Specs::LABEL => 'Save user'
));
```

### Reset buttons

```php
$form->addElement('reset', array(
    Specs::TYPE => 'reset'
    Specs::LABEL => 'Reset form'
));
```

### Simple buttons
These are buttons that do not submit/reset the form

```php
$form->addElement('button', array(
    Specs::TYPE => 'button'
    Specs::LABEL => 'Show confirmation'
    Specs::ATTRIBUTES => array(
        'onclick' => 'showConfirmation()'
    )
));
```
