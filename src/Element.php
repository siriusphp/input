<?php
namespace Sirius\Forms;

use Sirius\Forms\Form;

/**
 * @method \Sirius\Forms\Element getLabel() Get the label text
 * @method \Sirius\Forms\Element setLabel($label) Set label text
 * @method \Sirius\Forms\Element getLabelAttributes() Get the attributes for the label
 * @method \Sirius\Forms\Element setLabelAttributes(array $attributes) Set label attributes
 * @method \Sirius\Forms\Element setLabelAttribute($attr, $value = null) Set/Unset label attribute
 * @method \Sirius\Forms\Element addLabelClass($class) Add a CSS class to the label
 * @method \Sirius\Forms\Element removeLabelClass($class) Removes a CSS class from the label
 * @method \Sirius\Forms\Element toggleLabelClass($class) Toggles a class on the label
 * @method \Sirius\Forms\Element getHint() Get the hint text
 * @method \Sirius\Forms\Element setHint($label) Set hint text
 * @method \Sirius\Forms\Element getHintAttributes() Get the attributes for the hint
 * @method \Sirius\Forms\Element setHintAttributes(array $attributes) Set hint attributes
 * @method \Sirius\Forms\Element setHintAttribute($attr, $value = null) Set/Unset hint attribute
 * @method \Sirius\Forms\Element addHintClass($class) Add a CSS class to the hint
 * @method \Sirius\Forms\Element removeHintClass($class) Removes a CSS class from the hint
 * @method \Sirius\Forms\Element toggleHintClass($class) Toggles a class on the hint
 * @method \Sirius\Forms\Element getContainerAttributes() Get the attributes for the container
 * @method \Sirius\Forms\Element setContainerAttributes(array $attributes) Set container attributes
 * @method \Sirius\Forms\Element setContainerAttribute($attr, $value = null) Set/Unset container attribute
 * @method \Sirius\Forms\Element addContainerClass($class) Add a CSS class to the container
 * @method \Sirius\Forms\Element removeContainerClass($class) Removes a CSS class from the container
 * @method \Sirius\Forms\Element toggleContainerClass($class) Toggles a class on the container
 * @method \Sirius\Forms\Element getOptions() Get list of options for SELECTS, radio or checkbox groups
 * @method \Sirius\Forms\Element setOptions(array $options) Set list of options for SELECTs, radio or checkbox groups
 * @method \Sirius\Forms\Element getFirstOption() Get the first/empty option for SELECT 
 * @method \Sirius\Forms\Element setFirstOption($option) Set the first/empty option for SELECT
 * @method \Sirius\Forms\Element getUploadContainer() Get the upload container for the element
 * @method \Sirius\Forms\Element setUploadContainer($container) Set the upload container for the element
 * @method \Sirius\Forms\Element getUploadOptions() Get the upload options for the container
 * @method \Sirius\Forms\Element setUploadOptions(array $options) Set the upload options for the container
 * @method \Sirius\Forms\Element getUploadRules() Get the upload validation rules
 * @method \Sirius\Forms\Element setUploadRules(array $rules) Set the upload validation rules
 */
abstract class Element extends Element\Specs
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
    const HINT = '';
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
     *
     * @var \Sirius\Forms\Form
     */
    protected $form;

    /**
     * Name of the field (identifier of the element in the form's child list)
     * @var string
     */
    protected $name;

    protected $value;

    /**
     *
     * @param string $name
     *            Name of the form element that will make it identifiable
     * @param array $specs
     *            Specification for the element (attributes, parents, etc)
     */
    function __construct($name, $specs = array())
    {
        parent::__construct(array_merge($this->getDefaultSpecs(), $specs));
        $this->name = $name;
    }
    
    protected function getDefaultSpecs() {
        return array();
    }

    function setForm(\Sirius\Forms\Form $form) {
        $this->form = $form;
        return $this;
    }

    /**
     *
     * @return \Sirius\Forms\Form;
     */
    function getForm() {
        return $this->form;
    }

    protected function getName() {
    	return $this->name;
    }
    
    protected function getValue() {
    	if ($this->form) {
    		return $this->form->getValue($this->getName());
    	} 
    	return $this->value;    	
    }

    protected function getRawValue() {
    	if ($this->form) {
    		return $this->form->getRawValue($this->getName());
    	} 
    	return $this->value;
    }

    
}