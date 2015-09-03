---
title: Understanding forms
---

# Understanding forms

Before learning how to create forms using **Sirius\Input** there are a couple of things that must be explained. That's because there are differences on how other libraries attempt to solve the "forms problem".

Forms are difficult because they cross-cut concerns: **data** and **presentation**.

When data is entering your system it would be relatively easy to filter and validate it before persisting it to database or something. Similarly, if you were to render a form it would be relatively easy to create some view helpers to help you with producing labels, text inputs and the like. But this way the 2 processes are decoupled and limits the flexibility of your app (like adding custom fields via plugins). Another difficulty comes from the fact that data comes from 2 sources: $_FILES and $_POST.

From the **Sirius\Input** point of view a form is:

1. a collection of elements (fields, fieldsets, buttons etc), where
2. each elements specifies the expected structure of the incoming data, the transformations it requires before validation, its validation rules and
3. has instructions for the view layer on how the it should be rendered (a HTML form, a template for a single-page-app etc)

This approach has some consequences, explained below.

## 1. Form elements are just "specs"

One important thing about **Sirius\Input** is that the form elements are just a list of specifications that will instruct the behaviour of other elements. Each element of a form has specifications that:

1. instruct the input sanitizer (the filtrator) on the filters that are applied before validation
2. instruct the validator on the criteria that the data must meet
3. instruct the upload handler on the validation rules for the uploaded files and the destination of these files
4. instruct the view layer (the renderer) on the visual representation of that form

Other libraries treat form elements as "independent objects" with a life of their own. This is an over-engineered solution because **filtering and validation happens at the form level**. 
For any reasonably complex form the data processing happens in context. For example, when the user checks some box another field becomes "required". Because when working with forms you need to validate and filter input data as a set, not as invididual values, that responsibility is left to a validator object attached to the form, not the element itself.

## 2. Data you get is not the data you need

This goes without saying but here are few areas special attention is needed:

### 2.1. Localized inputs

Your user may send you his/her birth date as `01.25.1995` but your app needs to have it normalized to `1995-01-25` (or a DateTime object). For this you need to use filters. The process is like this

    get localized date
        > filters get applied (localized date is normalized)
            > now you have normalized date which you can
                > save it to the database
                > or display it localized

No need to construct complex objects that knows how to normalize/localize data. Your form elements must **specify** the normalization filters that must be applied to the incoming data and your rendered widgets must be able to localize variables.

### 2.2. Multi-part input fields

This is somehow related to the point above (localized inputs) as it is part of the larger group of problems that appear when there are differences in the life-time of a single piece of data (from the app's persistence layer to the view layer and from the user's input to the persistance layer).

A date field may be rendered as a set of 3 input fields (day,month,year) so to convert it from an array to a single value you need filters for the incoming data. At the view layer the widgets will take care of retrieving its 3 pieces of data from the single, normalized, value. Since form elements are just specs, this reponsabilities are delegated to the filtrator object (which has the responsibility to normalize the input data) and the renderer (which has the responsibility to localize the output data).

### 2.3. File uploads

**Sirius\Input** treats file uploads as an intermediary step between the user's input and the system's input. Take the example of a profile form where you need to allow the user to upload its profile picture. You will get a `$_FILES['picture']` from the client but what you really want is pass the uploaded file name to an user's model `picture` property. If you were to have an AJAX uploader you would get the result of the AJAX upload as a string that you would use to populate a `<input type="hidden" name="picture">` field. With the advance of such techniques this is now pretty much the norm.

This is exactly the approach **Sirius\Input** uses when handling file uploads; a specific procedure takes the uploaded files and tries to converted the result of the upload into a string (just like an AJAX uploader would do) that will become the value of the desired form field element. So, while there may be a `$_FILES['picture']` value, the end result will be similar to having a `$_POST['picture']` value. If there are upload processing errors (ie: at the $_FILES level) the form will received (and display) additional error messages

**Sirius\Input** treats the processing of file uploads as a standalone operation. The processing of uploaded files consists of sanitizing the file names, validating the files against the upload rules and moving the valid uploads to their destination. This is done automatically through a set of _UploadHandlers_ provided by the **Sirius\Upload** library.
