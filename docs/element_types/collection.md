# Collection

Collections contain a repeatable set of elements.

In case of a form representing an invoice there is a __collection__ of invoice lines which may contain fields like: product name, quantity, price per item.

### Add a collection to form

```php
// construct your fielset in one command
$form->addElement('lines', array(
	Specs::TYPE => 'collection'
	Specs::CHILDREN => array(
		'product' => array (
			Specs::TYPE => 'text'
		),
		'quantity' => array (
			Specs::TYPE => 'text'
		),
		'price' => array (
			Specs::TYPE => 'text'
		)
	)
));
```

### Add an element to collection

```php
// or add the children later
$collection = $form->getElement('lines');

$collection->addElement('total', array(
	Specs::TYPE => 'text'
));
```

### Change an element from a collection

```php
// alter the collection's children any time
$total = $collection->getElement('total');
$total->setAttribute('readonly', 'readonly');
```

## Collections vs fieldsets

Similarly to fielsets, the child elements of a collection are namespaced. But they also have an index. In the example above the `quantity` inputs will have the `name` attribute set as `lines[{lines_index}][quantity]`

**Important!** Just like in the case of [Fieldsets](Fieldset.md) this will have implications on the data validation and filtration.

**Warning** The "collections inside collections" behaviour is not tested yet.
