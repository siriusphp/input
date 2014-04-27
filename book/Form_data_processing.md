# Form data processing

Use the `populate()` method to attach data on the form

```php
$form->populate(array_merge($_POST, $_FILES));
```

When the populate method is executed the following operations are executed

1. **data is filtrated**. The unfiltered data is still accessible.
2. **uploaded files** are processed. Valid uploads are passed on the proper fields (you'll see later what that means)
3. **data is validated**. After the data is validated, the upload errors are added to the form's validation error messages

This means that if the form is populated with invalid data the form will have error messages. Sometimes this is not the behaviour you want (eg: the use gets a form populated with data from the database and you don't want to show the errors immediately). To do that you must clear the validator's messages

```php
$form->getValidator()->clearMessages();
```
