# Input elements

Input elements classes extend the `Element\Input` class.

This is how you add an element to a form (you do the same for fieldsets and collections).

```php
// the code below relies on the element factory to instanciate the element
$form->addElement('email', array(
    Specs::LABEL => 'Your email',
    Specs::HINT => 'We will send you an account activation email after registration',
    Specs::VALIDATION_RULES => array(
        'required',
        'email'
    ),
    Specs::FILTERS => array(
        'stringtrim'
    )
));
```

## Built-in input fields

The **Sirius\Forms** library comes packed with a variaty of input fields the cover most of the use-cases:

1. Text - the DEFAULT value
2. Textarea - a text input displayed as a textarea
3. Checkbox - an element that will have a specific value if the user checks it
4. File - this is a special type of element as you will see in the ["uploads" section](Processing_forms/Uploads.md)
5. Select - an element that has a list of valid choices from which only one can be chosen
6. Multiselect - an element that has a list of valid choices from which one or more can be chosen

They diverge very little from the base **Element\Input** class so, by looking at their code, you'll be able to understand what it takes to create your own custom elements.

**Reminder!** The type of form elements have little to do how they are displayed. The renderer is responsible for the visual representation of the form and its elements. So you can choose to render an element of type `select` as a dropdown widget (using the SELECT tag), an autocomplete jQuery UI widget or a set of radio buttons.
