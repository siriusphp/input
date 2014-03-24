# Getting started with Sirius\Forms

Before learning how to create forms using **Sirius\Forms** there are a couple of things that must be explained because there are differences between the ways libraries attempt to solve the "form problem".

## Form elements are just specs

One important thing about **Sirius\Forms** is that its doesn't approach the construction of elements as fully-functional objects that can have a life of their own. For example, Zend Framework's form elements are attached to an input object which has validators and filters. This gives you the "chance" to test a "full featured" form element.

IMO, this is an overengineered solution because filtering and validation happens at the form level. If you only need one input field that you need to filter and validate, that's an easy task to accomplish with only a couple of helper classes. Since you need to validate and filter input data as a set, not and invididual value, that functionality is left to the responsibility of a validator object. For this purpose Sirius\Forms uses [Sirius\Validaton](http://github.com/siriusphp/validation) and [Sirius\Filtration](http://github.com/siriusphp/filtration). For processing uploads we use [Sirius\Upload](http://github.com/siriusphp/upload)

Since data handling (filtering, upload, validation) is delegated to other object there is no need for form elements to be anything else but a collection of specifications (objects with properties but no "life).

## Data received through the form is not what your app needs

This goes without saying but there are few areas where this idea has effects: file uploads, localization, special form widgets

### Uploads need special treatment

Anybody who ever build a complex form knows this simple truth. **Sirius\Forms** treats the processing of file uploads as a standalone operation. The processing of uploaded files consists of sanitizing the file names, validating the files against the upload rules and moving the valid uploads to their destination. 

Take the example of a profile form where you need to allow the user to upload its profile picture. You will get a $_FILES['picture'] from the client but what you really want is pass the uploaded file name to an user's model `picture` property. If you were to have an AJAX uploader you would get the result of the AJAX upload as a string that you would use to populate a `<input type="hidden" name="picture">` field.

This is exactly the approach **Sirius\Forms** uses when handling file uploads; a specific procedure takes the uploaded files and tries to converted into a string, just like an AJAX uploader would do. If there are upload processing errors (ie: failed upload, invalid file etc) the form gets additional error messages; if everything was correct, the forms input data gets a new value.

### Locatization == filtration

Your user may send you his/her birth date as `01.25.1995` but your app needs to have it normalized to `1995-01-25`. For this you need to use filters. Again, no need to construct complex objects that know how to normalize/localize data. At the view layer, the form renderer object must be able to construct widgets that can localize variables.

### Special widgets need filters too

A date field may be rendered as a set of 3 input fields (day,month,year). To converted from an array to a single value you need filters for the incoming data. At the view level the widgets will take care of retrieving its 3 pieces of data from the single value.

### 

## A forms life-cycle

During its existence a form goes through a few stages

#### Initialization
Here the the form is constructed; it has its dependencies injected, its properties (CSS class, method etc) and its children specified.

#### Preparation
At this point the form is prepared to accept data. The form's validator object is populated with rules from the elements' spec, the filtrator object has its filters configured (again, from the elements' specs) and upload handlers are configured

#### Receiving data
Here the form gets data (_POST and _FILE) which is filtered, validated and processed and processed (in the case of uploads). 

#### Rendering
This is one of the hardest part in the life of the form. While there are a lot of libraries that can help you with data filtering and validation I haven't found one that allows you to render complex form with only one line.

## The Sirius\Forms promise

The **Sirius\Forms**' promise is that managing a form life-cyle will be very simple, like so

```php
// the construction of the form require some dependencies
$form = new Form();
// add the form elements specs here

// in your controller set the data and ex
$form->setData($_POST, $_FILES);
if ($form->isValid()) {
    // business logic here
}

// in your views just call
$formRenderer->render($form);
```