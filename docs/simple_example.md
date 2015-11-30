---
title: Simple input example
---

# Simple example

The `Sirius\Input` library can be used to handle any data coming to your app but this example will refer to a form.

### Initialize your form

Let's consider a simple contact form that has the following field: `name`, `email`, `phone`, `message` and `source`.

```php
use Sirius\Input\InputFilter;

$contactForm = new InputFilter();
$contactForm->addElement('name', array(
    // type of input element from Sirius\Input\Element
    Specs::TYPE => 'text',
    // label of the input
    Specs::LABEL => 'Your name',
    // attributes for the label
    Specs::LABEL_ATTRIBUTES => ['class' => 'emphasized'],
    // how the input will be rendered, defaults to 'text'
    Specs::WIDGET => 'text',
    Specs::VALIDATION_RULES => ['required']
    Specs::FILTERS => ['trim'],    
));

$contactForm->addElement('email', array(
    Specs::TYPE => 'text',
    // the class constants are here to help you but they are not mandatory
    'label' => 'Your email',
    Specs::ATTRIBUTES => ['placeholder' => 'me@domain.com'],
    Specs::WIDGET => 'email',
    Specs::VALIDATION_RULES => 'required | email', // this is accepted by Sirius\Validation library
    Specs::FILTERS => ['trim']
));

$contactForm->addElement('phone', array(
    Specs::TYPE => 'text',
    Specs::LABEL => 'Your phone'
    Specs::FILTERS => ['trim']
));

$contactForm->addElement('message', array(
    Specs::TYPE => 'textarea',
    Specs::LABEL => 'Message',
    Specs::HINT => 'Please be as detailed as possible'
    Specs::FILTERS => ['trim','strip_tags']
));

$contactForm->addElement('source', array(
    Specs::TYPE => 'select',
    Specs::LABEL => 'Where did you hear about us',
    Specs::WIDGET => 'radiobuttons', // this will instruct the renderer how to display the input element
    Specs::OPTIONS => array('Search engines', 'Somebody I know', 'Newsletter', 'TV/Radio ad')    
));

$contactForm->addElement('submit', array(
    Specs::TYPE => 'submit',
    Specs::LABEL => 'Send request',
));

```

### Process data and validate

```php

if ($_POST) {
    $contactForm->populate($_POST);
    if ($contactForm->isValid()) {
        // get a copy of the 'clean' data (the data that was filtered)
        $formData = $contactForm->getValues();
    
        // send an email to the customer support,
        // send a copy to the client,
        // save the data into a database or
        // push it to a CRM
        $crmClient->call('inquries.new', $formData);
    } else {
        $errors = $contactForm->getErrors();
    }
}
```