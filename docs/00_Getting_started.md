# Getting started with Sirius\Forms

The **Sirius\Forms**' promise is that managing a form life-cyle will be very easy, like so

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

Before learning how to create forms using **Sirius\Forms** there are a couple of things that must be explained because there are differences between the ways libraries attempt to solve the "form problem".

## Form elements are just "specs"

One important thing about **Sirius\Forms** is that its doesn't approach the construction of elements as fully-functional objects that can have a life of their own. For example, Zend Framework's form elements are attached to an input object which has validators and filters. This gives you the "chance" to test a "full featured" form element.

IMO, this is an overengineered solution because filtering and validation happens at the form level. If you only need one input field that you need to filter and validate, that's an easy task to accomplish in a couple of lines. Since you need to validate and filter input data as a set, not and invididual values, that functionality is left to the responsibility of a validator object (ZF2 has an `inputFilter` object associated with the form for this purpose). 

For this purpose **Sirius\Forms** uses
1. [Sirius\Validaton](http://github.com/siriusphp/validation) for validation
2. [Sirius\Filtration](http://github.com/siriusphp/filtration) for filtering/sanitizing data. 
3. [Sirius\Upload](http://github.com/siriusphp/upload) for handling uploads

Since data handling (filtering, upload, validation) is delegated to other objects there is no need for form elements to be anything else but a collection of specifications (objects with properties but almost "lifeless").

## Data you get is not the data you need

This goes without saying but there are few areas special attention is needed: 

### 1. File uploads

Anybody who ever build a complex form knows this simple truth. Take the example of a profile form where you need to allow the user to upload its profile picture. You will get a $_FILES['picture'] from the client but what you really want is pass the uploaded file name to an user's model `picture` property. If you were to have an AJAX uploader you would get the result of the AJAX upload as a string that you would use to populate a `<input type="hidden" name="picture">` field.

This is exactly the approach **Sirius\Forms** uses when handling file uploads; a specific procedure takes the uploaded files and tries to converted into a string, just like an AJAX uploader would do. If there are upload processing errors (ie: failed upload, invalid file etc) the form gets additional error messages; if everything was correct, the forms input data gets a new value.

**Sirius\Forms** treats the processing of file uploads as a standalone operation. The processing of uploaded files consists of sanitizing the file names, validating the files against the upload rules and moving the valid uploads to their destination. All is done automatically through a set of _UploadHandlers_ provided by the **Sirius\Upload** library. 


### 2. Localized inputs

Your user may send you his/her birth date as `01.25.1995` but your app needs to have it normalized to `1995-01-25`. For this you need to use filters. The process is like this

    get localized data 
        > filters get applied 
            > now you have normalized data which you can
                > save it to the database or
                > display it localized

Again, no need to construct complex objects that know how to normalize/localize data. Your form elements must be specify the normalization filters to be applied to the incoming data and your rendered widgets must be able to localize variables.

### 3. Multi-part input fields

A date field may be rendered as a set of 3 input fields (day,month,year). To convert it from an array to a single value you need filters for the incoming data. At the view level the widgets will take care of retrieving its 3 pieces of data from the single value. Since form elements are just specs, this reponsabilities are delegated to the filtrator object and the renderer.

## A forms life-cycle

During its existence a form goes through a few stages

### 1.Instanciation and dependency injection
**Sirius\Forms** forms have a few contructor dependencies (which have default values) but your application's forms might depend on other things. If that's the case its recommended to use setters to inject your dependencies.

### 2. Initialization
The `init()` method is called automatically prior to preparation. It doesn't do anything by default but you can use it for your application form to define the form's properties and elements.

### 3. Preparation
At this point the form is prepared to accept data. The form's validator object is populated with rules from the elements' spec, the filtrator object has its filters configured (again, from the elements' specs) and upload handlers are configured. The form's `prepare()` method is executed automatically before receiving data or rendering.

You can extend this method to alter the form in whatever way you want (add new elements, change elements, add custom validation rules etc).

**Important! While you can add/change/remove fields from a form after the preparation you must be aware that these changes might not propagate to the form's depedencies (filtrator/validator/upload handlers)

### 4. Receiving data
The `setData()` method is how the gets data (_POST and _FILE) which is filtered, validated and processed and processed (in the case of uploads). 

### 5. Rendering
This is one of the hardest part in the life of the form. While there are a lot of libraries that can help you with data filtering and validation you'll have a hard time finding a library that allows you to render complex forms with one line (Drupal is the only project that I found that can do that).

