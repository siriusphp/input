---
title: Filtering incoming data
---

# Filtering incoming data

The **Sirius\Input** library uses the [Sirius\Filtration](http://www.sirius.ro/php/sirius/filtration) library.

The `filters` property of an element specs is an array of filters. For each filter up to 4 parameters are needed

- name of the filter
- options for the filter (optional)
- is the filter recursive? (optional boolean, defaults to false)
- the filter's priority (integer, optional). The order the filters are applied matters!

These are the parameters required by the `Sirius\Validation\Filtrator::add()` method and they can be provided in a format that is recognizable by the **Sirius\Filtration** library.

```php
$form->addElement('date', array(
    'label' => 'Date'
	'filters' => array(
		// simple filter that uses the default options
		'stringtrim',
		// usual definition of filter
		array('normalizedate', 'd/m/Y')
	),
));
```

In the example above the filters are specified at a field level. This means they will be applied only to the $_POST['date'] value. If you want to add a filter at the form's level you have to do the same.

```php
$form->setFilters(array(
    // first filter to be applied
    array(
        'xss_prevention',   // apply XSS prevention filter
        [],                 // array of options for the filter
        true,               // this is a recursive filter
        100                 // priority of the filter
    )
));
```

[You can learn more about Sirius\Filtration](http://www.sirius.ro/php/sirius/filtration).

## Adding/changing/removing filters

While this is not a usual scenario, you can alter the filters of an input element (via plugins/events) 

```php
$filters = $form->getElement('date')->getFilters(); // this is an array
// remove a filter
unset($filters[0]);
// add a filter
$filters[] = 'xss_protection';

// then you have to pass it back
$form->getElement('date')->setFilters($filters);
```

You may take advantage of  [`Sirius\Filtration\Filtrator::add()` syntactic-sugar ](http://www.sirius.ro/php/sirius/filtration/syntactic_sugar.html)