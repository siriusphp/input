#Sirius Forms

**Sirius\Forms** library is a framework agnostic library for creating, validating and rendering forms. The goal of the library is to be the only form library you will ever use.

The **Sirius\Forms**' promise is that managing a form life-cyle will be very easy, like so

```php
// the construction of the form require some dependencies, but all of them have defaults
$form = new Form();
// add the form elements here like
$form->add('level', array(
    // type of form element from Sirius\Forms\Element
    'type' => 'select',
    // how the element will be rendered
    'widget' => 'radioset',
    // label details
    'label' => 'Your level',
    'label_attributes' => ['class' => 'emphasized'],
    // instructions for completing the form
    'hint' => 'Provide your expertize level with regard to Sirius\Forms'
    // choices for the radio buttons
    'options' => ['none', 'beginner', 'senior', 'expert']
    'validation_rules' => ['required']
));

// in your controller set the data and ex
$form->setData(array_merge($_POST, $_FILES));
if ($form->isValid()) {
    // business logic here
}

// in your views just call
$formRenderer->render($form);
```


In order to manage all the aspects of a form the **Sirius\Forms** library depends on:

* [Sirius\Validaton](http://github.com/siriusphp/validation) for validation
* [Sirius\Filtration](http://github.com/siriusphp/filtration) for filtering/sanitizing data.
* [Sirius\Upload](http://github.com/siriusphp/upload) for handling uploads

