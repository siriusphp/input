<?php
namespace Sirius\Input\Element;

use Sirius\Input\Element\Input;
use Sirius\Input\Element;

class Factory
{

    protected $types = array(
        'text'        => '\Sirius\Input\Element\Input\Text',
        'file'        => '\Sirius\Input\Element\Input\File',
        'textarea'    => '\Sirius\Input\Element\Input\Textarea',
        'select'      => '\Sirius\Input\Element\Input\Select',
        'multiselect' => '\Sirius\Input\Element\Input\MultiSelect',
        'checkbox'    => '\Sirius\Input\Element\Input\Checkbox',
        'button'      => '\Sirius\Input\Element\Button',
        'submit'      => '\Sirius\Input\Element\Button\Submit',
        'reset'       => '\Sirius\Input\Element\Button\Reset',
        'group'       => '\Sirius\Input\Element\Group',
        'collection'  => '\Sirius\Input\Element\Collection',
        'fieldset'    => '\Sirius\Input\Element\Fieldset',
    );

    function registerElementType($type, $classOrClosure)
    {
        if ($classOrClosure instanceof \Closure) {
            $this->types[$type] = $classOrClosure;

            return $this;
        }
        if (!is_string($classOrClosure)) {
            throw new \RuntimeException('Input type must be a class or a closure');
        }
        if (!class_exists($classOrClosure)) {
            throw new \RuntimeException(sprintf('Class %s does not exist', $classOrClosure));
        }
        if (!is_subclass_of($classOrClosure, '\Sirius\Input\Element')) {
            throw new \RuntimeException(
                sprintf('Class %s must extend the \Sirius\Input\Element class', $classOrClosure)
            );
        }
        $this->types[$type] = $classOrClosure;

        return $this;
    }

    /**
     * Create element from options
     *
     * @param $name
     * @param array $options
     *
     * @return \Sirius\Input\Element
     * @throws \RuntimeException
     */
    function createFromOptions($name, $options = array())
    {
        $type = 'text';
        if (isset($options[Input::TYPE]) && isset($this->types[$options[Input::TYPE]])) {
            $type = $options[Input::TYPE];
            unset($options[Input::TYPE]);
        }
        /* @var $element \Sirius\Input\Element */
        if ($this->types[$type] instanceof \Closure) {
            $element = call_user_func($this->types[$type], $name, $options);
        } else {
            $class   = $this->types[$type];
            $element = new $class($name, $options);
        }

        if (!$element instanceof Element) {
            throw new \RuntimeException('Cannot create a valid element based on the data provided');
        }

        // if the element is a fieldset/collection type, inject the element factory
        if ($element instanceof FactoryAwareInterface) {
            $element->setElementFactory($this);
        }

        return $element;
    }
}
