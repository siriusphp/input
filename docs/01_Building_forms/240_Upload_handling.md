# Upload handling

The **Sirius\Forms** library uses the [Sirius\Upload](http://github.com/siriusphp/upload) library.

For each element that is of type `file` the library will construct an __"upload handler"__. For this reason, the element specs need to contain:

- the container
- upload options
- upload validation rules

```php
$form->add('picture', array(
    'label' => 'Picture'
	'upload_container' => 'images/products/'
	'upload_rules' => array(
		['image', ['type' = > ['jpg', 'png'], 'File must be a JPG or PNG']
		['width', ['max' => 1000], 'No more than {max} pixels wide please']
	),
	'upload_options' => [
		// prefix for the uploaded file
		'prefix' => time(),
		// overwrite if a file with the same name is already there
		'overwrite' => true,
	]
));

```

The container can be a local folder or an instance of `Sirius\Upload\Container\ContainerInterface`.

**Important!** Files are uploaded under a name that is equal to: `__upload_` + the form's element name. So, in the example above the `$_FILES` array should contain a `__upload_picture` entry.

This is done to prevent name collisions in modern apps that use Javascript upload. In such apps an Ajax uploader will populate the field `picture` with the result of the successful upload.


[Learn more about Sirius\Upload](http://github.com/siriusphp/upload)