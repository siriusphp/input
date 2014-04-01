# Introduction to form rendering

When it comes to form rendering the goal of the **Sirius\Forms** library is to do that in one line

```php
echo $formRenderer->render($form);
```

To reach this goal the render process works like this:

1. The renderer object contains a set of `WidgetFactories` which take a form element and generates an widget. 
2. The widget created by the factory is a DOM-like object that has a string representation (through `__toString()`) and contains other DOM-like objects (the label, the input, the error message etc). The form itself is a widget that contains other widgets as its children. The widgets have a [jQuery like interface](../10_API/Widget.md) for manipulation.
3. The form renderer has a collection of `Decorators` which receive the widgets for manipulation. A decorator can potentially return a different widget than the one it received it is capable of creating one so the decorators give you absolute flexibility on the end result of the rendering process.

The `Decorators` and `WidgetFactories` are independent. Theoretically you can have decorators that can work with widgets produced by other widget factories.

Since all the form's elements are just specs you can create your own renderers. It is easy to create renderers that generate Mustache templates for Single-Page-Apps.

While you don't have to write all the code below to instantiate the default renderer (because it has sensible defaults) here's what a form renderer is supposed to work:

```php
$widgetFactory = \Sirius\Forms\WidgetFactory\Default;
$formRenderer = \Sirius\Forms\Renderer\Default();
$formRenderer->registerWidgetFactory($widgetFactory); // this happens by default

$formRenderer->registerDecorator(new \Sirius\Forms\Decorators\Required); // this is done by default
$formRenderer->registerDecorator(new \MyApplication\FormDecorators\Translate($translator));
$formRenderer->registerDecorator(new \MyApplication\FormDecorators\Autocomplete);

// later after everything is working

echo $formRenderer->render($form);
```

The **Sirius\Forms** library comes with:
1. a basic form renderer 
2. a widget factory that uses Twitter's Bootstrap format for the widgets it generates 
3. a bunch of widget decorators.
