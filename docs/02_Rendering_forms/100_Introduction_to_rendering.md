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

$formRenderer->addWorker(new \Sirius\Forms\WidgetFactory\Worker\WidgetMaker); // this is done by default
$formRenderer->addWorker(new \Sirius\Forms\WidgetFactory\Worker\HintMaker); // this is done by default
$formRenderer->addWorker(new \Sirius\Forms\WidgetFactory\Worker\LabelMaker); // this is done by default
$formRenderer->addWorker(new \Sirius\Forms\WidgetFactory\Worker\ErrorMaker); // this is done by default
$formRenderer->addWorker(new \Sirius\Forms\WidgetFactory\Worker\ChildrenComposer); // this is done by default
$formRenderer->addWorker(new \MyApp\Forms\WidgetFactory\Worker\Translator);
$formRenderer->addWorker(new \MyApp\Forms\WidgetFactory\Worker\Themer);

// later after everything is working

echo $formRenderer->render($form);
```

The process of rendering a form is broken into the following steps:

1. The form and each of its elements are passed to the widget factory to create form widgets (programmable HTML tags with a simple interface)
2. The widget factory uses different "workers" to produce widgets out of the form and its elements.

Widget factory workers are ordered based on a `priority` and they receive the task of creating a widget. Depending on the status of the task they might perform different operations, like:

1. Creating the widget
2. Attaching an error message element to the widget
3. Creating the children for a fieldset
4. Translating the label, error messages and other items
5. Adding Boostrap classes to specific elements

As you can see the order the workers are organized matters a lot; a worker responsible for attaching the label to the element will not be able to do so if the worker responsible for creating the widget did that before it.

The task that is passed from worker to worker is a simple object that contains:

1. The widget factory - this way a worker may ask for different things from the factory (eg: a worker responsible to attach the children of a fieldset to a widget will ask the widget factory to provide it with the children)
2. The form - this way a worker might get data from the form's validator object (eg: a worker that attaches client side validation to the form)
3. The element - the element that is being processed during the execution of the task
4. The result - the widget that is going to be the result of the build process (eg: the "labeler" worker will attach an label to the result)