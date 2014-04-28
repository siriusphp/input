# Custom elements

You can create your own custom elements to use in your apps.

For example if you have lots of forms that have input fields that use the jQuery UI's date picker widget you might want to create a custom element like so:

```php
class DatePicker extends \Sirius\Forms\Element\Input\Text
{
    function getDefaultSpecs()
    {
        // the specs defined here are merged with the one you
        // provide to the form's add() method
        return array(
            Element::ATTRIBUTES => array(
                'class' => 'datepicker'
            ),
            'format' => 'Y-m-d'
        );
    }

    protected function prepareFormFiltration(\Sirius\Forms\Form $form)
    {
        parent::prepareFormFiltration($form);
        $filtrator = $form->getFiltrator();
        // add a custom filter to the form's filtrator to normalize the incoming value
        $filtrator->add($this->getName(), /* filter callback */);
    }
}
```

Other times you might want to create your own custom fieldsets and/or collections

```php
namespace MyApp\Forms\Element;

class AddressFieldset extends \Sirius\Forms\Element\Fieldset
{
    function init() {
        $this->add('street', $streetSpecs);
        $this->add('city', $citySpecs);
    }

}
```

and add it to the form something like so:

```php
// somewhere in your app bootstrap
$formElementFactory->registerElementType('address_fielset', 'MyApp\Forms\Element\AddressFieldset');

// in your app
$form->add('address, array(
    'type' => 'address_fielset'
));
```
