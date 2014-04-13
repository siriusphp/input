<?php
namespace Sirius\Forms;

use Sirius\Forms\Form;

/**
 *
 * @method Element getLabel() Get the label text
 * @method Element setLabel($label) Set label text
 * @method Element getLabelAttributes() Get the attributes for the label
 * @method Element setLabelAttributes(array $attributes) Set label attributes
 * @method Element setLabelAttribute($attr, $value = null) Set/Unset label attribute
 * @method Element addLabelClass($class) Add a CSS class to the label
 * @method Element removeLabelClass($class) Removes a CSS class from the label
 * @method Element toggleLabelClass($class) Toggles a class on the label
 * @method Element getHint() Get the hint text
 * @method Element setHint($label) Set hint text
 * @method Element getHintAttributes() Get the attributes for the hint
 * @method Element setHintAttributes(array $attributes) Set hint attributes
 * @method Element setHintAttribute($attr, $value = null) Set/Unset hint attribute
 * @method Element addHintClass($class) Add a CSS class to the hint
 * @method Element removeHintClass($class) Removes a CSS class from the hint
 * @method Element toggleHintClass($class) Toggles a class on the hint
 * @method Element getContainerAttributes() Get the attributes for the container
 * @method Element setContainerAttributes(array $attributes) Set container attributes
 * @method Element setContainerAttribute($attr, $value = null) Set/Unset container attribute
 * @method Element addContainerClass($class) Add a CSS class to the container
 * @method Element removeContainerClass($class) Removes a CSS class from the container
 * @method Element toggleContainerClass($class) Toggles a class on the container
 * @method Element getOptions() Get list of options for SELECTS, radio or checkbox groups
 * @method Element setOptions(array $options) Set list of options for SELECTs, radio or checkbox groups
 * @method Element getFirstOption() Get the first/empty option for SELECT
 * @method Element setFirstOption($option) Set the first/empty option for SELECT
 * @method Element getValidationRules() Get list of validation rules
 * @method Element setValidationRules(array $rules) Set list of validation rules
 * @method Element getFilters() Get list of data filters
 * @method Element setFilters(array $filters) Set list of filters
 * @method Element getUploadContainer() Get the upload container for the element
 * @method Element setUploadContainer($container) Set the upload container for the element
 * @method Element getUploadOptions() Get the upload options for the container
 * @method Element setUploadOptions(array $options) Set the upload options for the container
 * @method Element getUploadRules() Get the upload validation rules
 * @method Element setUploadRules(array $rules) Set the upload validation rules
 */
abstract class Element extends \ArrayObject
{
    /**
     * Constants to be used by setSpec(), getXXX(), setXXX()
     */
    const ATTRIBUTES = 'attributes';

    const LABEL = 'label';

    const LABEL_ATTRIBUTES = 'label_attributes';

    const PRIORITY = 'priority';

    const GROUP = 'group';

    const CONTAINER_ATTRIBUTES = 'container_attributes';

    const HINT = 'hint';

    const HINT_ATTRIBUTES = 'hint_attributes';

    const VALIDATION_RULES = 'validation_rules';

    const FILTERS = 'filters';

    const WIDGET = 'widget';

    const ELEMENT_TYPE = 'element_type';

    const OPTIONS = 'options';

    const FIRST_OPTION = 'first_option';

    const UPLOAD_CONTAINER = 'upload_container';

    const UPLOAD_OPTIONS = 'upload_options';

    const UPLOAD_RULES = 'upload_rules';

    /**
     * Name of the field (identifier of the element in the form's child list)
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @param string $name
     *            Name of the form element that will make it identifiable
     * @param array $specs
     *            Specification for the element (attributes, parents, etc)
     */
    function __construct($name, $specs = array())
    {
        $specs = array_merge($this->getDefaultSpecs(), $specs);
        parent::__construct($specs, \ArrayObject::STD_PROP_LIST);
        $this->name = $name;
    }

    /**
     * Returns the default element specifications
     * To be used for easily extending objects
     *
     * @return array
     */
    protected function getDefaultSpecs()
    {
        return array();
    }

    /**
     * Retrieve the name of the form's element as registered within the form
     *
     * @return string
     */
    function getName()
    {
        return $this->name;
    }

    function setAttributes($attrs) {
        return $this->setAttributesFor('', $attrs);
    }

    function getAttributes() {
        return $this->getAttributesFor('');
    }

    function getAttribute($attr) {
        return $this->getAttributeFor('', $attr);
    }

    function setAttribute($attr, $value = null) {
        return $this->setAttributeFor('', $attr, $value);
    }

    function addClass($class) {
        return $this->addClassFor('', $class);
    }

    function removeClass($class) {
        return $this->removeClassFor('', $class);
    }

    function toggleClass($class) {
        return $this->toggleClassFor('', $class);
    }

    /**
     * Adds a class on an attribute container
     * $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target
     * @param string $className
     * @return AbstractElement
     */
    protected function addClassFor($target, $className)
    {
        $class = $this->getAttributeFor($target, 'class') ? : '';
        if (!in_array($className, explode(' ', $class))) {
            $class .= ' ' . $className;
            $this->setAttributeFor($target, 'class', trim($class));
        }
        return $this;
    }

    /**
     * Remove a class from an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $className
     * @return AbstractElement
     */
    protected function removeClassFor($target, $className)
    {
        $class = $this->getAttributeFor($target, 'class') ? : '';
        $classesList = explode(' ', $class);
        if (in_array($className, $classesList)) {
            $classesList = array_diff($classesList, array($className));
            $this->setAttributeFor($target, 'class', trim(implode(' ', $classesList)));
        }
        return $this;
    }

    /**
     * Toggles a class on an attribute container
     * $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $className
     * @return AbstractElement
     */
    protected function toggleClassFor($target, $className)
    {
        $class = $this->getAttributeFor($target, 'class') ? : '';
        $classesList = explode(' ', $class);
        if (in_array($className, $classesList)) {
            $classesList = array_diff($classesList, array($className));
        } else {
            $classesList[] = $className;
        }
        $this->setAttributeFor($target, 'class', trim(implode(' ', $classesList)));
        return $this;
    }

    /**
     * Set attributes on to an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target (ex: NULL, label, hint etc)
     * @param array $attributes
     * @return AbstractElement
     */
    protected function setAttributesFor($target, array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->setAttributeFor($target, $attribute, $value);
        }
        return $this;
    }

    /**
     * Retrieve attributes from an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target (ex: NULL, label, hint etc)
     * @return mixed
     */
    protected function getAttributesFor($target)
    {
        $target = strtolower($target);
        $key = 'attributes';
        if ('' !== $target) {
            $key = $target . '_attributes';
        }
        // ensure the attributes are an array
        if (!isset($this[$key]) || !is_array($this[$key])) {
            $this[$key] = array();
        }
        return $this[$key];
    }

    /**
     * Sets a single attribute on an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $attribute (ex: id, class, disabled)
     * @param mixed $value
     * @return AbstractElement
     */
    protected function setAttributeFor($target, $attribute, $value = null)
    {
        $target = strtolower($target);
        $key = 'attributes';
        if ($target) {
            $key = $target . '_attributes';
        }
        if (!isset($this[$key]) || !is_array($this[$key])) {
            $this[$key] = array();
        }
        if ($value === null) {
            $container = $this[$key];
            unset($container[$attribute]);
            $this[$key] = $container;
            return $this;
        }
        $this[$key][$attribute] = $value;
        return $this;
    }

    /**
     * Get a single attribute from an attribute container
     * ex: $this['attributes'], $this['label_attributes'], $this['hint_attributes'])
     *
     * @param string $target (ex: NULL, label, hint etc)
     * @param string $attribute (ex: id, class, disabled)
     * @return mixed|NULL
     */
    protected function getAttributeFor($target, $attribute)
    {
        $attrs = $this->getAttributesFor($target);
        if (isset($attrs[$attribute])) {
            return $attrs[$attribute];
        }
        return null;
    }



    /**
     * Prepares the form to receive data and be rendered
     * It attaches the filters, validation rules, upload handler for the element
     * If the element has children the method is executed on the children as well
     *
     * @param Form $form
     */
    function prepareForm(Form $form)
    {
        $this->prepareFormValidation($form);
        $this->prepareFormFiltration($form);
        $this->prepareFormUploadHandling($form);
    }

    protected function prepareFormUploadHandling(Form $form)
    {

    }
}
