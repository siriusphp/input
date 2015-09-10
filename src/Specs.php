<?php
namespace Sirius\Input;


class Specs extends \ArrayObject
{
    /**
     * Attributes for the input and input elements
     */
    const DATA = 'data';

    const ATTRIBUTES = 'attributes';

    const LABEL = 'label';

    const LABEL_ATTRIBUTES = 'label_attributes';

    const POSITION = 'position';

    const GROUP = 'group';

    const CONTAINER_ATTRIBUTES = 'container_attributes';

    const HINT = 'hint';

    const HINT_ATTRIBUTES = 'hint_attributes';

    const VALIDATION = 'validation_rules';
    const VALIDATION_RULES = 'validation_rules';

    const FILTERS = 'filters';

    const WIDGET = 'widget';

    const ELEMENT_TYPE = 'type';

    const TYPE = 'type';

    const OPTIONS = 'options';

    const FIRST_OPTION = 'first_option';

    const UNCHECKED_VALUE = 'unchecked_value';

    const CHECKED_VALUE = 'checked_value';

    const UPLOAD_CONTAINER = 'upload_container';

    const UPLOAD_OPTIONS = 'upload_options';

    const UPLOAD_RULES = 'upload_rules';

    const CHILDREN = 'children';


    protected function inflectUnderscoreToClass($var)
    {
        $var = str_replace('_', ' ', $var);
        $var = ucwords($var);

        return str_replace(' ', '', $var);
    }

    function get($key)
    {
        $method = 'get' . $this->inflectUnderscoreToClass($key);
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return isset($this[$key]) ? $this[$key] : null;
    }

    function set($key, $value)
    {
        $method = 'set' . $this->inflectUnderscoreToClass($key);
        if (method_exists($this, $method)) {
            return $this->{$method}($value);
        }
        $this[$key] = $value;

        return $this;
    }


}
