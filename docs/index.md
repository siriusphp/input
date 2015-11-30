#Sirius Input

[![Source Code](http://img.shields.io/badge/source-siriusphp/input-blue.svg?style=flat-square)](https://github.com/siriusphp/input)
[![Latest Version](https://img.shields.io/packagist/v/siriusphp/input.svg?style=flat-square)](https://github.com/siriusphp/input/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/siriusphp/input/blob/master/LICENSE)
[![Build Status](https://img.shields.io/travis/siriusphp/input/master.svg?style=flat-square)](https://travis-ci.org/siriusphp/input)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/siriusphp/input.svg?style=flat-square)](https://scrutinizer-ci.com/g/siriusphp/input/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/siriusphp/input.svg?style=flat-square)](https://scrutinizer-ci.com/g/siriusphp/input)
[![Total Downloads](https://img.shields.io/packagist/dt/siriusphp/input.svg?style=flat-square)](https://packagist.org/packages/siriusphp/input)

Sirius Input is a framework agnostic PHP library for handling data coming to your application. It is suitable for forms and APIs (RESTful or not)

It depends on:
 
- [Sirius\Validation](http://www.sirius.ro/php/sirius/validation/) for validating the data, 
- [Sirius\Filtration](http://www.sirius.ro/php/sirius/filtration/) for filtering/sanitizing data and 
- [Sirius\Upload](http://www.sirius.ro/php/sirius/upload/) for handling file uploads

##Elevator pitch

```php
$form = new \Sirius\Input\InputFilter();

$form->add('name', [
	'type' => 'text',
	'label' => 'Name',
	'rules' => ['required']
]);
$form->add('email', [
	'type' => 'text',
	'label' => 'Email',
	'rules' => ['required', 'email']
]);
$form->add('message', [
	'type' => 'textarea',
	'label' => 'Message',
	'hint' => 'Please write in detail the problem you were facing',
	'rules' => ['required']
]);
$form->add('submit', [
	'type' => 'submit',
	'label' => 'Send message'
]);

$form->populate($_POST);

if ($form->isValid()) {
	// send message to admin, log to database etc
} else {
	$view->set('errors', $form->getErrors());
}
```

The `Sirius\Input` library doesn't render the forms for 3 reasons:

1. the library can be used for handling data coming from APIs. In this case a more appropriate "render target" would be the API documentation
2. different frameworks implement different ways to render things. Think about how to handle CSS/JS dependencies.
3. Single Responsibility Principle

But because rendering forms is such a big part in any project we creates [`Sirius\FormsRenderer`](http://www.sirius.ro/php/sirius/formsrenderer/) as a starting base for such task.