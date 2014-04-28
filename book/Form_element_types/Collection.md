# Collection

Collections contain repeatable set of elements.

In case of a form representing an invoice there is a __collection__ of invoice lines which may contain fields like: product name, quantity, price per item.

### Add collection to form

```php
// construct your fielset in one command
$form->add('lines', array(
	Element::TYPE => 'collection'
	Element::CHILDREN => array(
		'product' => array (
			Element::TYPE => 'text'
		),
		'quantity' => array (
			Element::TYPE => 'text'
		),
		'price' => array (
			Element::TYPE => 'text'
		)
	)
));
```

### Add element to collection

```php
// or add the children later
$collection = $form->get('lines');

$collection->add('total', array(
	Element::TYPE => 'text'
));
```

### Change collection element

```php
// alter the collection's children any time
$total = $collection->get('total');
$email->setAttribute('readonly', 'readonly');
```

## Collections vs fieldsets

Similarly to fielsets, the child elements of a collection are namespaced. But they also have an index. In the example above the `quantity` inputs will have the `name` attribute set as `lines[{index}][quantity]`

**Important!** Just like in the case of [Fieldsets](Fieldset.md) this will have implications on the validation and filtration.

**Warning** You can add collections inside of collections but this behaviour is not tested.
