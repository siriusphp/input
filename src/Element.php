<?php
namespace Sirius\Input;

use Sirius\Input\Traits\HasAttributesTrait;
use Sirius\Input\Traits\HasDataTrait;

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
abstract class Element extends Specs
{
    use HasAttributesTrait;
    use HasDataTrait;
    
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
        foreach ($specs as $key => $value) {
            $this->set($key, $value);
        }
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

    /**
     * Sets the group this element belongs to
     *
     * @param null|string $group
     *
     * @return $this
     */
    function setGroup($group = null) {
        $this[Element::GROUP] = (string) $group;
        return $this;
    }

    /**
     * Retrieve the group this element belongs to
     *
     * @return null|string
     */
    function getGroup() {
        return isset($this[Element::GROUP]) ? $this[Element::GROUP] : null;
    }

    /**
     * Sets the widget for this element
     *
     * @param null|string $widget
     *
     * @return $this
     */
    function setWidget($widget = null) {
        $this[Element::WIDGET] = (string) $widget;
        return $this;
    }

    /**
     * Retrieve the widget type for this element
     *
     * @return string
     */
    function getWidget() {
        return isset($this[Element::WIDGET]) ? $this[Element::WIDGET] : null;
    }

    /**
     * Sets the display priority for this element
     *
     * @param integer $priority
     *
     * @return $this
     */
    function setPosition($priority = 0) {
        $this[Element::POSITION] = (int) $priority;
        return $this;
    }

    /**
     * Retrieve display position for this element
     *
     * @return integer
     */
    function getPosition() {
        return isset($this[Element::POSITION]) ? $this[Element::POSITION] : 0;
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
        if (method_exists($this, 'prepareFormValidation')) {
            $this->prepareFormValidation($form);
        }
        if (method_exists($this, 'prepareFormFiltration')) {
            $this->prepareFormFiltration($form);
        }
        if (method_exists($this, 'prepareFormUploadHandling')) {
            $this->prepareFormUploadHandling($form);
        }
    }

}
