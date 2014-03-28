# Introduction to rendering

When it comes to the rendering of a form the **Sirius\Forms** library's goals is to do that in one line

```php
echo $formRenderer->render($form);
```

To reach this goal the render process is following the steps below

1. The form renderer object works with a set of `WidgetFactories` which take a form element and generates an widget. Needless to say that each form renderer must have at least one such factory.
2. The widget that is created by the factory is a DOM-like object that has a textual representation (through `__toString()`) and contains other DOM-like objects (the label, the input, the error message etc). The form itself is a widget that contains other widgets as its children.
3. The form renderer has a registry of `Decorators` which receive the widgets for manipulation. A decorator can potentially return a different widget than the one it received it is capable of creating one so the decorators give you absolute flexibility on the end result of the rendering process.

The `Decorators` and `WidgetFactories` are independent. Theoretically you can have decorators that can work with widgets produced by other widget factories.

Since all the form's elements are just specs you can create your own renderers. It is easy to create renderers that generate form templates for Single-Page-Apps in Mustache or other client-side templating library.

The **Sirius\Forms** library comes with a form renderer with a widget factory that uses Twitter's Bootstrap format for the widgets it generates and comes with a bunch of decorators.

While you don't have to write the code below to instantiate the default renderer (because it instantiates everything by default for you) here's what a form renderer is supposed to be constructed:

```php
$widgetFactory = \Sirius\Forms\WidgetFactory\Default;
$formRenderer = \Sirius\Forms\Renderer\Default($widgetFactory);

$formRenderer->registerDecorator(new \Sirius\Forms\Decorators\Required);
$formRenderer->registerDecorator(new \MyApplication\FormDecorators\Translate($translator));
$formRenderer->registerDecorator(new \MyApplication\FormDecorators\Autocomplete);
```