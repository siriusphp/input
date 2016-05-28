---
title: Adding elements to forms
---

# Adding elements to forms

## Add an element as specifications

If you want the element factory to create the elements that you add to the form you only need to provide the name of the element (so it can later be retrieved) and the element' specifications:

```php
use Sirius\Input\Specs;

// provide specs for the element factory
$specs = array(
	Specs::TYPE => 'text',
	Specs::LABEL => 'Your email address'
);
$form->add('email', $specs);

// you can retrieve the element so you alter it
$email = $form->get('email');
```

## Add an element instance

If you like boilerplate, you can create the form element by yourself you can do that as well

```php
use Sirius\InputGuardian\Element\Input\Text;

$email = new Text('email', array(
	Specs::LABEL => 'Your email address'
));
$form->add($email);
```

<div class="warning">
    <strong>Warning!</strong> Doing this you lose the advantages offered by the <a href="element_factory.html">ElementFactory</a> which constructs the elements based on the `type` value (this allows you to globally change the implementation of a particular type of input).
</div>

As you can see, the `Specs` class has a lot of constants that you can use when defining the element specifications. Just type `Specs::` and let your IDE do the rest!
