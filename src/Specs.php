<?php
namespace Sirius\Input;


class Specs
{
    /**
     * Extra options for the input element
     */
    const DATA = 'data';

    /**
     * Info used by the view layer to render the widget's input field section (eg: HTML attributes)
     */
    const ATTRIBUTES = 'attributes';

    /**
     * The text of the input's label
     */
    const LABEL = 'label';

    /**
     * Info used by the view layer to render the widget's label section (eg: HTML attributes)
     */
    const LABEL_ATTRIBUTES = 'label_attributes';

    /**
     * The display order of the element inside it's container (form, group, fieldset)
     */
    const POSITION = 'position';

    /**
     * The name of the element which visually includes the current element
     */
    const GROUP = 'group';

    /**
     * Info used by the view layer to render the widget (eg: HTML attributes)
     */
    const CONTAINER_ATTRIBUTES = 'container_attributes';

    /**
     * Instructions about filling out the input
     */
    const HINT = 'hint';

    /**
     * Info used by the view layer to render the widget's hint section (eg: HTML attributes)
     */
    const HINT_ATTRIBUTES = 'hint_attributes';

    /**
     * The validation rules used to verify the validity of a value
     */
    const VALIDATION = 'validation_rules';
    const VALIDATION_RULES = 'validation_rules';

    /**
     * The list of filter rules to be applied to the value
     */
    const FILTERS = 'filters';

    /**
     * The type of UI element
     */
    const WIDGET = 'widget';

    /**
     * The type of Input element to be constructed
     */
    const ELEMENT_TYPE = 'type';
    const TYPE = 'type';

    /**
     * The list of acceptable choices for "select" type of elements
     */
    const CHOICES = 'choices';

    /**
     * The first option (the label for NULL) for "select" type of elements
     */
    const FIRST_CHOICE = 'first_choice';

    /**
     * The value to be sent by the client when a "checkbox" is not checked
     */
    const UNCHECKED_VALUE = 'unchecked_value';

    /**
     * The value to be sent by the client when a "checkbox" is checked
     */
    const CHECKED_VALUE = 'checked_value';

    /**
     * The container for the uploaded files (@see \Sirius\Upload\Handler)
     */
    const UPLOAD_CONTAINER = 'upload_container';

    /**
     * The upload options (@see \Sirius\Upload\Handler)
     */
    const UPLOAD_OPTIONS = 'upload_options';

    /**
     * The validation rules for the uploaded files (@see \Sirius\Upload\Handler)
     */
    const UPLOAD_RULES = 'upload_rules';

    /**
     * The children for FORMs or FIELDSETs
     */
    const CHILDREN = 'children';

}
