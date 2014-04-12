<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element;
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
abstract class Input extends Specs
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
     * Name of the field (identifier of the element in the form's child list)
     *
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

    /**
     * Returns the default element specifications
     * To be used for easily extending objects
     *
     * @return array
     */
    protected function getDefaultSpecs()
    {
        return array(
            static::WIDGET => 'text',
            static::ATTRIBUTES => array(
                'type' => 'text'
            )
        );
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

    function getValue()
    {
        return $this->value;
    }

    function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    function prepareForm(Form $form)
    {
        $this->prepareFormValidation($form);
        $this->prepareFormFiltration($form);
        $this->prepareFormUploadHandling($form);
    }

    protected function prepareFormFiltration(Form $form)
    {
        $filters = $this->getFilters();
        if (!$filters || !is_array($filters)) {
            return;
        }
        $filtrator = $form->getFiltrator();
        foreach ($filters as $filter) {
            $params = is_array($filter) ? $filter : array($filter);
            if (isset($params[0])) {
                $filtrator->add($this->getName(), $params[0], @$params[1], @$params[2], @$params[3]);
            }
        }
    }

    protected function prepareFormValidation(Form $form)
    {
        $validationRules = $this->getValidationRules();
        if (!$validationRules || !is_array($validationRules)) {
            return;
        }
        $validator = $form->getValidator();
        foreach ($validationRules as $rule) {
            $params = is_array($rule) ? $rule : array($rule);
            if (isset($params[0])) {
                $validator->add($this->getName(), $params[0], @$params[1], @$params[2], $this->getLabel());
            }
        }

    }

    protected function prepareFormUploadHandling(Form $form)
    {

    }
}
