# Filtration

The **Sirius\Forms** library uses the [Sirius\Filtration](http://github.com/siriusphp/filtration) library.

The `filters` property of an element specs is an array of filters. For each filter 2 parameters are needed

- name of the filter
- options for the filter (optional)

These are the parameters required by the `Sirius\Validation\Filtrator::add()` method and they can be provided in a format that is recognizable by the **Sirius\Filtration** library.

```php
$form->add('date', array(
    'label' => 'Date'
	'filters' => array(
		// simple filter that uses the default options
		'stringtrim',
		// usual definition of filter
		array('normalizedate', ['format' => 'd/m/Y'])
		// filter that uses all options
		array('xss_prevention', [], true /* apply the filter recursively */, 1000 /* the priority*/)
	),
));

```

[Learn more about Sirius\Filtration](http://github.com/siriusphp/filtration)
