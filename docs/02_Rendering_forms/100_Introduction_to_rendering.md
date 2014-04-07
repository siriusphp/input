# Introduction to form rendering

When it comes to form rendering the goal of the **Sirius\Forms** library is to do that in one line

```php
echo $formRenderer->render($form);
```

To reach this goal the render process works like this:

1. The renderer object contains a `WidgetFactory` which take a form element and generates an widget. 
2. The widget created by the factory is a DOM-like object that has a string representation (through `__toString()`) and contains other DOM-like objects (the label, the input, the error message etc). The form itself is a widget that contains other widgets as its children. The widgets have a [very simple interface](../10_API/Widget.md).
3. The form renderer has a collection of `Decorators` which receive the widgets for manipulation. 

The `Decorators` and `WidgetFactories` are independent. Theoretically you can have decorators that can work with widgets produced by other widget factories.

Since all the form's elements are just specs you can create your own renderers. It is easy to create renderers that generate Mustache templates for Single-Page-Apps.

While you don't have to write all the code below to instantiate the default renderer (because it has sensible defaults) here's what a form renderer is supposed to work:

```php
$widgetFactory = \Sirius\Forms\WidgetFactory\Base;
$formRenderer = \Sirius\Forms\Renderer\Basic($widgetFactory);

$formRenderer->registerDecorator(new \Sirius\Forms\Decorators\Required); // this is done by default
$formRenderer->registerDecorator(new \MyApplication\FormDecorators\Translate($translator));
$formRenderer->registerDecorator(new \MyApplication\FormDecorators\Autocomplete);

// later after everything is working

echo $formRenderer->render($form);
```

The process of rendering a form is broken into the following steps
1. The form and each of its elements are passed to the widget factory create form widgets (programmable HTML tags with a simple interface)
2. The widget factory uses different "workers" to process the form and its element into widgets. A worker might be in charge of creating the label field, another responsible for constructing the input field etc.
3. The form widget is passed to the registered decorators for... decoration. The decorators are also executed recursively the form's children.

While you can achieve the same result without using decorators and using only workers, there is a distinction between "workers" and "decorators": "workers" are smart, "decorators" are dumb. 

Workers are very aware of their environment. When they process form element they are have knowledge about the form they are coming from (for example they can extract data from the validator), and about the factory itself (they can issue a request to the factory for another element if they need that). On the other hand, decorators only work with the resulting widget; they may add an HTML attribute here and there, translate some piece of data but the operations they perform are very simple.