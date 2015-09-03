---
title: Rendering
---

# Rendering forms

To render `Sirius\Input\InputFilter` objects you need a set of routines to convert each form element to a string. Each form element has `widget` property that instructs the rendered on the type of representation

Below is an example of a function that renders a simple `SELECT`
```php
function renderSelect($form, $element) {
    $out = '<div class="form-group">';
    
    $errorMessage = $form->getValidator()->getError($element->getName());
    if ($errorMessage) {
        $out .= '<p class="alert alert-danger">' . $errorMessage . '</p>';
    }
    
    $out .= '<label class="col-sm-3">' . $element->getLabel() . '</label>';
    
    $value = $form->getValue($element->getName());
    
    // the rest goes here
    
    if ($element->getHint()) {
        $out .= '<p class="form-hint">' . $element->getHint() . '</p>';
    }
    
    $out .= '</div>';
    return $out;
}
```

Obviously this is not a very good solution because 

1. it's application specific (if you want to switch from Bootstrap you need to refactor your whole code) and 
2. it's not very flexible (for each new view layer instruction you need to change the code to take it into account)

For these reasons we created the [`Sirius\FormsRenderer`](http://www.sirius.ro/php/sirius/formsrenderer) library which lets you render HTML forms from `InputFilter` objects while being 100% flexible.

# Rendering documentation

Just like you need a library to convert an input filter list of specification to a form you can use a renderer to output it as a documentation (for an API entry point for example).

If you think MVC, the `InputFilter` object is the `Model` and as long as you have a `View` you can get anything.