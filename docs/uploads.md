---
title: Handling file uploads
---

# File uploads

The **Sirius\Input** library uses the [Sirius\Upload](http://github.com/siriusphp/upload) library.

For each element that is of type `file` the library will construct an __"upload handler"__. For this reason, the element specs need to contain:

- the container
- upload options
- upload validation rules

```php
$form->add('picture', array(
    Specs::LABEL => 'Picture'
	Specs::UPLOAD_CONTAINER => 'public/images/products/'
	Specs::UPLOAD_RULES => array(
		['image', ['type' = > ['jpg', 'png']], 'File must be a JPG or PNG']
		['width', ['max' => 1000], 'No more than {max} pixels wide please']
	),
	Specs::UPLOAD_OPTIONS => array(
		// prefix for the uploaded file
		'prefix' => time(),
		// overwrite if a file with the same name is already there
		'overwrite' => true,
	)
));

```

The container can be a local folder or an instance of `Sirius\Upload\Container\ContainerInterface`.

**Important!** The upload handler expects the files to be uploaded under a name prefixed with `__upload_`. In the example above, for the `picture` field, the `$_FILES` array should contain a `__upload_picture` entry.

This is done to prevent name collisions in modern apps that use Javascript for uploading. In such apps an Ajax uploader will populate a hidden field with `name="picture"` with the result of the successful upload which is actually the desired end result (to populate the user's `picture` attribute with the uploaded file).

[Learn more about Sirius\Upload](http://www.sirius.ro/php/sirius/upload)
