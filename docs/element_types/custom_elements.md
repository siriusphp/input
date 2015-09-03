# Custom elements

You can create your own custom elements to use in your apps. Although the library's basic elements can display almost any form, there a few reasons to create custom elements.

## To be DRY (Don't Repeat Yourself)

The `Element` class has a `getDefaultSpecs()` method that you can use to provide defaults. Here's a date picker element which has some default specs that you will not be forced to write everytime you need to add a datepicker to a form.

```php
namespace MyApp\Forms\Element;

class DatePicker extends \Sirius\Forms\Element\Input\Text
{
    const FORMAT = 'format'; // a custom specification

    function getDefaultSpecs()
    {
        // the specs defined here are merged with the one you
        // provide to the form's add() method
        return array(
            Specs::ATTRIBUTES => array(
                'class' => 'datepicker'
            ),
            self::FORMAT => 'd/m/Y'
        );
    }

    protected function prepareFormFiltration(\Sirius\Forms\Form $form)
    {
        parent::prepareFormFiltration($form);
        $filtrator = $form->getFiltrator();
        // add a custom filter to the form's filtrator to normalize the incoming value
        $filtrator->add($this->getName(), array($this, 'normalizeDate'));
    }

    function normalizeDate($date) {
        // convert a date provided as 'd/m/Y' to 'Y-m-d'
    }
}
```

The same reason applies if you want to create custom composite elements (fieldsets or collections)

```php
namespace MyApp\Forms\Element;

class AddressFieldset extends \Sirius\Forms\Element\Fieldset
{
    function init() {
        $this->add('street', $streetFieldSpecs);
        $this->add('city', $cityFieldSpecs);
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

## Special data processing
Let's say you have a localized date input called `start_date` that is localized and your renderer actually renders the field as `name="__localized_start_date"` which is converted by javascript into a system-formated date and populated into a hidden field with `name="start_date"`. If the client doesn't have javascript support that will pose a problem (you will not have the `start_date` populated via JS). So you need to make sure that the transformation is done server-side as well

```php
namespace MyApp\Forms\Element;

class LocalizedDate extends \Sirius\Input\Element\Input\Text {

    function convertLocalizedDate($data) {
        // $data here will be the form's data
        $data[$this->getName()] = strptime($data['__localized_' . $this-getName()], 'm/d/y');
        // you have to return the data (see documentation for Sirius\Filtration)
        return $data;
    }

    protected function prepareFormFiltration($form) {
        parent::prepareFormFiltration($form);
        // this adds a callback as a filtration rule
        // to be applied to the entire form data (not an individual item)
        $form->getFiltration()->add('/', array($this, 'convertLocalizedDate'));
    }
}
```
